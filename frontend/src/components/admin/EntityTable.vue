<template>
  <div
    :key="`table-${tableKey}`"
    class="bg-gray-50 w-full flex justify-start items-center p-3 rounded-t-md"
  >
    <div class="w-10">
      <input
        type="checkbox"
        ref="masterbox"
        v-model="topCheckboxValue"
        @change="topCheckboxHandler"
        class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900"
      />
    </div>

    <div class="flex flex-col md:flex-row justify-between w-full">
      <div
        v-for="(key, i) in getTitles"
        :key="`text-${i}`"
        class="text hidden md:block"
        :style="`width: ${columnWidth}%;`"
      >
        {{ key }}
      </div>
    </div>
  </div>
  <hr />
  <div v-if="totalItems == 0" class="bg-white w-full p-3 border-b">
    {{ $t("dashboard.noItemsAvailable") }}
  </div>
  <div
    v-for="(item, j) in content"
    :key="`row-${j}`"
    class="bg-white w-full p-3 border-b flex justify-start items-center overflow-y-hidden"
  >
    <div class="w-10">
      <input
        type="checkbox"
        @change="(e) => changeBox(e, item['id'])"
        v-model="checkBoxValues[item['id']]"
        class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900"
      />
    </div>
    <template v-for="(key, i) in keys" :key="`text-${j}-${i}`">
      <template v-if="actions[key] && actions[key].actionName == 'image'">
        <div class="justify-start items-center md:hidden px-5">
          <ColoredLogoCircle
            class="size-20"
            :size="actions[key].args.includes('color') ? 65 : 100"
            :src="item[key] ? `${backendURL}${item[key].thumbnail}` : undefined"
            :backgroundColor="item?.color"
          />
        </div>
      </template>
    </template>
    <div
      class="flex flex-col md:flex-row md:items-center justify-between w-full"
    >
      <div
        v-for="(key, i) in keys"
        :key="`text-${j}-${i}`"
        class="text"
        :style="`width: ${isDesktop ? columnWidth : '100'}%;`"
      >
        <template v-if="actions[key] && actions[key].actionName == 'link'">
          <router-link
            class="text-sm text-blue-600 hover:text-blue-900"
            :to="`${entity}/${item[actions[key].actionArgument]}`"
            >{{ item[key] || $t("dashboard.noValue") }}</router-link
          >
        </template>
        <template v-if="actions[key] && actions[key].actionName == 'image'">
          <div class="justify-start items-center hidden md:block">
            <ColoredLogoCircle
              class="size-16"
              :size="actions[key].args.includes('color') ? 65 : 100"
              :src="
                item[key] ? `${backendURL}${item[key].thumbnail}` : undefined
              "
              :backgroundColor="item?.color"
            />
          </div>
        </template>
        <template v-if="actions[key] && actions[key].actionName == 'date'">
          <div class="text-sm text-gray-500">{{ formatDate(item[key]) }}</div>
        </template>
        <template v-if="!actions[key]">
          <div class="text-sm text-gray-500">{{ getValue(item, key) }}</div>
        </template>
      </div>
    </div>
  </div>
  <PaginationNav
    :pageNumber="page"
    :itemsPerPage="itemsPerPage"
    :totalItems="totalItems"
    @goToPage="(i) => goToPage(i)"
  />
</template>

<script>
import { get } from "lodash";
import PaginationNav from "./PaginationNav.vue";
import { format } from "date-fns";
import ColoredLogoCircle from "./ColoredLogoCircle.vue";
export default {
  components: { PaginationNav, ColoredLogoCircle },
  props: ["entity", "columns", "titles"],
  emits: ["changeSelected"],
  data() {
    return {
      content: undefined,
      keys: undefined,
      actions: {},
      page: 1,
      totalItems: -1,
      itemsPerPage: 1,
      paginationKey: 0,
      topCheckboxValue: false,
      checkBoxValues: {},
      tableKey: 0,
      selected: new Set([]),
      isDesktop: window.innerWidth > 768,
    };
  },
  computed: {
    columnWidth() {
      return parseInt(90 / this.columns.split(",").length);
    },
    getTitles() {
      return this.titles.split(",");
    },
  },
  watch: {
    checkBoxValues: {
      handler(newValue) {
        if (Object.values(newValue).every((value) => value === true)) {
          this.$refs.masterbox.checked = true;
        } else {
          this.$refs.masterbox.checked = false;
        }
      },
      deep: true,
    },
  },
  methods: {
    getValue(obj, key) {
      return get(obj, key);
    },
    formatDate(date) {
      return format(new Date(date), "dd.MM.yyyy HH:mm");
    },
    changeBox(event, iri) {
      if (event.target.checked) {
        this.selected.add(iri);
      } else {
        this.selected.delete(iri);
      }

      this.$emit("changeSelected", Array.from(this.selected));
    },
    topCheckboxHandler() {
      if (this.topCheckboxValue) {
        Object.keys(this.checkBoxValues).forEach(
          (cbv) => (this.checkBoxValues[cbv] = true),
        );
        this.selected = new Set(Object.keys(this.checkBoxValues));
        this.$emit("changeSelected", Array.from(this.selected));
        this.tableKey++;
      } else {
        Object.keys(this.checkBoxValues).forEach(
          (cbv) => (this.checkBoxValues[cbv] = false),
        );
        this.selected = new Set([]);
        this.$emit("changeSelected", Array.from(this.selected));
        this.tableKey++;
      }
    },
    setUpBoxes() {
      this.content.forEach((item) => {
        this.checkBoxValues[item["id"]] = false;
      });
    },
    goToPage(i) {
      this.page = i;
      this.getItems();
      window.scrollTo(0, 0);
    },
    async getItems() {
      try {
        const response = await this.callApi(
          "get",
          `/${this.entity}`,
          {},
          {
            params: {
              page: this.page,
              dashboard: true,
              perPage: 20,
            },
          },
        );
        if (response.status == 204) {
          this.page = 1;
          this.getItems();
          return;
        }
        this.content = response.data.data;
        this.totalItems = response.data.total;
        this.itemsPerPage = response.data.perPage;

        this.tableKey++;
        this.paginationKey++;
      } catch (e) {
        console.log(e);
      }
    },
    entryProcessor() {
      const columns = this.columns.split(",");
      this.keys = columns.map((column) => {
        if (column.split(":").length === 1) {
          return column;
        } else {
          const [columnName, action] = column.split(":");
          const [actionName, ...params] = action.split(/\(|\)/);
          this.actions[columnName] = {
            actionName,
          };
          if (params.length > 0) {
            const actionParams = params[0].split(";");
            this.actions[columnName].actionArgument = actionParams[0];
            this.actions[columnName].args = actionParams.slice(1);
          }
          return columnName;
        }
      });
    },
  },
  mounted() {
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize);
  },
  async created() {
    await this.getItems();
    this.setUpBoxes();
    this.entryProcessor();
  },
};
</script>

<style></style>
