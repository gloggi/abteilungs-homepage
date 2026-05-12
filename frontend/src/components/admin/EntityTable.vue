<template>
  <div class="w-full rounded-md border border-gray-200 overflow-hidden">
    <div
      class="bg-gray-50/50 w-full flex justify-start items-center p-3 border-b border-gray-200 gap-4"
    >
      <div class="w-10 flex items-center justify-center flex-none">
        <label class="hidden" for="master-checkbox"></label>
        <MasterCheckbox
          id="master-checkbox"
          :checked="isMasterChecked"
          :indeterminate="isPartiallyChecked"
          @change="toggleAllRows"
        />
      </div>

      <div class="flex flex-col md:flex-row w-full gap-4">
        <div
          v-for="header in table.getHeaderGroups()[0]?.headers ?? []"
          :key="header.id"
          class="hidden md:flex items-center gap-1 text-xs font-medium text-gray-500 uppercase tracking-wider select-none"
          :class="getColumnClass(header.column.id)"
          :style="header.column.getCanSort() ? { cursor: 'pointer' } : {}"
          @click="header.column.getToggleSortingHandler()?.($event)"
        >
          <FlexRender
            :render="header.column.columnDef.header"
            :props="header.getContext()"
          />
          <span
            v-if="header.column.getIsSorted() === 'asc'"
            class="text-gray-400"
            >↑</span
          >
          <span
            v-else-if="header.column.getIsSorted() === 'desc'"
            class="text-gray-400"
            >↓</span
          >
        </div>
      </div>
    </div>

    <div v-if="totalItems === 0 && !loading" class="bg-white w-full">
      <EmptyState :title="$t('dashboard.noItemsAvailable')" />
    </div>
    <div
      v-for="row in table.getRowModel().rows"
      :key="row.id"
      class="bg-white w-full p-3 border-b border-gray-100 last:border-0 flex justify-start items-center transition-colors hover:bg-gray-50/50 gap-4"
    >
      <div class="w-10 flex items-center justify-center flex-none">
        <label class="hidden" :for="`checkbox-${row.original.id}`"></label>
        <input
          :id="`checkbox-${row.original.id}`"
          type="checkbox"
          :checked="row.getIsSelected()"
          @change="row.toggleSelected($event.target.checked)"
          class="rounded-sm border-gray-300 text-gray-900 focus:ring-offset-0 focus:ring-0 cursor-pointer"
        />
      </div>
      <template v-for="col in columns" :key="`mobile-img-${row.id}-${col.key}`">
        <template v-if="col.type === 'image'">
          <div class="justify-start items-center md:hidden px-4">
            <ColoredLogoCircle
              class="size-12"
              :size="col.useColor ? 65 : 100"
              :src="
                row.original[col.key]
                  ? `${backendURL}${
                      row.original[col.key][col.imageField || 'thumbnail']
                    }`
                  : undefined
              "
              :backgroundColor="row.original?.color"
              :cover="cover"
            />
          </div>
        </template>
      </template>

      <div class="flex flex-col md:flex-row md:items-center w-full gap-4">
        <div
          v-for="cell in row.getVisibleCells()"
          :key="cell.id"
          class="text-sm text-gray-700 overflow-hidden text-ellipsis"
          :class="getColumnClass(cell.column.id)"
        >
          <FlexRender
            :render="cell.column.columnDef.cell"
            :props="cell.getContext()"
          />
        </div>
      </div>
    </div>

    <template v-if="loading">
      <div
        v-for="i in content.length === 0 ? 10 : 3"
        :key="`skeleton-${i}`"
        class="bg-white w-full p-3 border-b border-gray-100 last:border-0 flex justify-start items-center gap-4 animate-pulse"
      >
        <div class="w-10 flex items-center justify-center flex-none">
          <div class="h-4 w-4 bg-gray-200 rounded-sm"></div>
        </div>

        <div class="justify-start items-center md:hidden px-4 hidden">
          <div class="size-12 rounded-full bg-gray-200"></div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center w-full gap-4">
          <div
            v-for="(col, k) in columns"
            :key="`skeleton-col-${i}-${k}`"
            :class="getColumnClass(col.key)"
          >
            <div v-if="col.type === 'image'" class="hidden md:block">
              <div class="size-10 rounded-full bg-gray-200"></div>
            </div>
            <div
              v-else
              class="h-4 bg-gray-200 rounded-md w-3/4 max-w-[200px]"
            ></div>
          </div>
        </div>
      </div>
    </template>
  </div>

  <div ref="sentinel" class="h-1"></div>
</template>

<script setup>
import {
  ref,
  computed,
  watch,
  onMounted,
  onBeforeUnmount,
  getCurrentInstance,
  h,
  nextTick,
} from "vue";
import { RouterLink } from "vue-router";
import {
  useVueTable,
  getCoreRowModel,
  getSortedRowModel,
  FlexRender,
} from "@tanstack/vue-table";
import { get } from "lodash";
import { format } from "date-fns";
import ColoredLogoCircle from "./ColoredLogoCircle.vue";
import EmptyState from "./EmptyState.vue";
import MasterCheckbox from "./MasterCheckbox.vue";

const props = defineProps({
  entity: { type: String, required: true },
  columns: { type: Array, required: true },
  searchString: { type: String, default: "" },
  cover: { type: Boolean, default: false },
});

const emit = defineEmits(["changeSelected"]);

const instance = getCurrentInstance();
const callApi = (...args) => instance.proxy.callApi(...args);
const backendURL = computed(() => instance.proxy.backendURL);

const content = ref([]);
const page = ref(1);
const totalItems = ref(-1);
const lastPage = ref(1);
const loading = ref(false);
const isDesktop = ref(window.innerWidth > 768);
const sentinel = ref(null);
let observer = null;

const rowSelection = ref({});
const sorting = ref([]);

const hasMorePages = computed(() => page.value <= lastPage.value);

function formatDate(date) {
  return format(new Date(date), "dd.MM.yyyy HH:mm");
}

function getValue(obj, key) {
  return get(obj, key);
}

function getColumnClass(key) {
  if (!isDesktop.value) return "w-full mb-2 md:mb-0";
  const col = props.columns.find((c) => c.key === key);
  if (col?.type === "image") {
    return "flex-none w-auto";
  }
  return "flex-1";
}

const columnDefs = computed(() => {
  return props.columns.map((col) => {
    const { key, title, type } = col;

    return {
      id: key,
      accessorFn: (row) => get(row, key),
      header: () => title,
      enableSorting: true,
      cell: (info) => {
        const item = info.row.original;
        const value = info.getValue();

        if (!type) {
          return h("div", { class: "text-gray-500" }, getValue(item, key));
        }

        switch (type) {
          case "link":
            return h(
              RouterLink,
              {
                class:
                  "font-medium text-gray-900 hover:underline hover:text-gray-900 transition-colors",
                to: `${props.entity}/${item[col.linkKey]}`,
              },
              () => value || instance.proxy.$t("dashboard.noValue"),
            );

          case "image":
            return h(
              "div",
              { class: "justify-start items-center hidden md:block" },
              h(ColoredLogoCircle, {
                class: "size-10",
                size: col.useColor ? 65 : 100,
                src: item[key]
                  ? `${backendURL.value}${
                      item[key][col.imageField || "thumbnail"]
                    }`
                  : undefined,
                backgroundColor: item?.color,
                cover: props.cover,
              }),
            );

          case "date":
            return h(
              "div",
              { class: "text-gray-500" },
              value ? formatDate(value) : "",
            );

          case "list":
            return h(
              "div",
              { class: "text-gray-500" },
              Array.isArray(value)
                ? value.map((v) => v[col.listKey]).join(", ")
                : "",
            );

          default:
            return h("div", { class: "text-gray-500" }, getValue(item, key));
        }
      },
    };
  });
});

const table = useVueTable({
  get data() {
    return content.value;
  },
  get columns() {
    return columnDefs.value;
  },
  state: {
    get rowSelection() {
      return rowSelection.value;
    },
    get sorting() {
      return sorting.value;
    },
  },
  enableRowSelection: true,
  enableSorting: true,
  onRowSelectionChange: (updaterOrValue) => {
    const newValue =
      typeof updaterOrValue === "function"
        ? updaterOrValue(rowSelection.value)
        : updaterOrValue;
    rowSelection.value = newValue;
  },
  onSortingChange: (updaterOrValue) => {
    const newValue =
      typeof updaterOrValue === "function"
        ? updaterOrValue(sorting.value)
        : updaterOrValue;
    sorting.value = newValue;
  },
  getRowId: (row) => String(row.id),
  getCoreRowModel: getCoreRowModel(),
  getSortedRowModel: getSortedRowModel(),
  manualFiltering: true,
});

const isMasterChecked = computed(() => {
  const rows = table.getRowModel().rows;
  return rows.length > 0 && rows.every((row) => row.getIsSelected());
});

const isPartiallyChecked = computed(() => {
  const rows = table.getRowModel().rows;
  if (rows.length === 0) return false;
  const selectedCount = rows.filter((row) => row.getIsSelected()).length;
  return selectedCount > 0 && selectedCount < rows.length;
});

watch(
  rowSelection,
  (newSelection) => {
    const selectedIds = Object.entries(newSelection)
      .filter(([, v]) => v)
      .map(([id]) => id);
    emit("changeSelected", selectedIds);
  },
  { deep: true },
);

function toggleAllRows(event) {
  const checked = event.target.checked;
  table.toggleAllRowsSelected(checked);
}

async function loadMore() {
  if (loading.value || !hasMorePages.value) return;

  loading.value = true;
  try {
    const response = await callApi(
      "get",
      `/${props.entity}`,
      {},
      {
        params: {
          page: page.value,
          dashboard: true,
          perPage: 20,
          search: props.searchString,
        },
      },
    );

    if (response.status === 204) {
      page.value = 1;
      content.value = [];
      totalItems.value = 0;
      lastPage.value = 1;
      loading.value = false;
      return;
    }

    const newItems = response.data.data;
    content.value = [...content.value, ...newItems];
    totalItems.value = response.data.total;
    lastPage.value = response.data.lastPage;
    page.value++;
  } catch (e) {
    console.log(e);
  } finally {
    loading.value = false;
  }
}

function resetAndLoad() {
  page.value = 1;
  content.value = [];
  totalItems.value = -1;
  lastPage.value = 1;
  rowSelection.value = {};
  emit("changeSelected", []);
  loadMore();
}

watch(
  () => props.searchString,
  () => resetAndLoad(),
);

function handleResize() {
  isDesktop.value = window.innerWidth > 768;
}

function setupObserver() {
  observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && !loading.value && hasMorePages.value) {
        loadMore();
      }
    },
    { rootMargin: "200px" },
  );
  if (sentinel.value) {
    observer.observe(sentinel.value);
  }
}

onMounted(() => {
  window.addEventListener("resize", handleResize);
  nextTick(() => setupObserver());
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", handleResize);
  if (observer) {
    observer.disconnect();
  }
});

loadMore();
</script>

<style></style>
