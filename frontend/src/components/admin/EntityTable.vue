<template>
  <div class="w-full rounded-md border border-gray-200 overflow-hidden">
    <div
      class="bg-gray-50/50 w-full flex justify-start items-center p-3 border-b border-gray-200 gap-4"
    >
      <div class="w-10 flex items-center justify-center flex-none">
        <label class="hidden" for="master-checkbox"></label>
        <input
          id="master-checkbox"
          type="checkbox"
          ref="masterbox"
          v-model="topCheckboxValue"
          @change="topCheckboxHandler"
          class="rounded border-gray-300 text-gray-900 focus:ring-offset-0 focus:ring-0 cursor-pointer"
        />
      </div>

      <div class="flex flex-col md:flex-row w-full gap-4">
        <div
          v-for="(key, i) in getTitles"
          :key="`text-${i}`"
          class="hidden md:block text-xs font-medium text-gray-500 uppercase tracking-wider"
          :class="getColumnClass(keys?.[i])"
        >
          {{ key }}
        </div>
      </div>
    </div>

    <div v-if="totalItems == 0" class="bg-white w-full">
      <EmptyState :title="$t('dashboard.noItemsAvailable')" />
    </div>

    <div
      v-for="(item, j) in content"
      :key="`row-${j}`"
      class="bg-white w-full p-3 border-b border-gray-100 last:border-0 flex justify-start items-center transition-colors hover:bg-gray-50/50 gap-4"
    >
      <div class="w-10 flex items-center justify-center flex-none">
        <label class="hidden" :for="`checkbox-${item['id']}`"></label>
        <input
          :id="`checkbox-${item['id']}`"
          type="checkbox"
          @change="(e) => changeBox(e, item['id'])"
          v-model="checkBoxValues[item['id']]"
          class="rounded border-gray-300 text-gray-900 focus:ring-offset-0 focus:ring-0 cursor-pointer"
        />
      </div>

      <template v-for="(key, i) in keys" :key="`mobile-img-${j}-${i}`">
        <template v-if="actions[key] && actions[key].actionName == 'image'">
          <div class="justify-start items-center md:hidden px-4">
            <ColoredLogoCircle
              class="size-12"
              :size="actions[key].args.includes('color') ? 65 : 100"
              :src="
                item[key] ? `${backendURL}${item[key].thumbnail}` : undefined
              "
              :backgroundColor="item?.color"
              :cover="cover"
            />
          </div>
        </template>
      </template>

      <div class="flex flex-col md:flex-row md:items-center w-full gap-4">
        <div
          v-for="(key, i) in keys"
          :key="`text-${j}-${i}`"
          class="text-sm text-gray-700 overflow-hidden text-ellipsis"
          :class="getColumnClass(key)"
        >
          <template v-if="actions[key] && actions[key].actionName == 'link'">
            <router-link
              class="font-medium text-gray-900 hover:underline hover:text-gray-900 transition-colors"
              :to="`${entity}/${item[actions[key].actionArgument]}`"
              >{{ item[key] || $t("dashboard.noValue") }}</router-link
            >
          </template>

          <template v-if="actions[key] && actions[key].actionName == 'image'">
            <div class="justify-start items-center hidden md:block">
              <ColoredLogoCircle
                class="size-10"
                :size="actions[key].args.includes('color') ? 65 : 100"
                :src="
                  item[key] ? `${backendURL}${item[key].thumbnail}` : undefined
                "
                :backgroundColor="item?.color"
                :cover="cover"
              />
            </div>
          </template>

          <template v-if="actions[key] && actions[key].actionName == 'date'">
            <div class="text-gray-500">{{ formatDate(item[key]) }}</div>
          </template>

          <template v-if="actions[key] && actions[key].actionName == 'list'">
            <div class="text-gray-500">
              {{
                item[key].map((v) => v[actions[key].actionArgument]).join(", ")
              }}
            </div>
          </template>

          <template v-if="!actions[key]">
            <div class="text-gray-500">{{ getValue(item, key) }}</div>
          </template>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <PaginationNav
      :pageNumber="page"
      :itemsPerPage="itemsPerPage"
      :totalItems="totalItems"
      @goToPage="(i) => goToPage(i)"
    />
  </div>
</template>

<script>
import { get } from "lodash";
import PaginationNav from "./PaginationNav.vue";
import { format } from "date-fns";
import ColoredLogoCircle from "./ColoredLogoCircle.vue";
import EmptyState from "./EmptyState.vue";
export default {
  components: { PaginationNav, ColoredLogoCircle, EmptyState },
  props: ["entity", "columns", "titles", "searchString", "cover"],
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
          try {
            this.$refs.masterbox.checked = false;
          } catch {}
        }
      },
      deep: true,
    },
    searchString() {
      this.getItems();
    },
  },
  methods: {
    getColumnClass(key) {
      if (!this.isDesktop) return "w-full mb-2 md:mb-0";
      if (this.actions[key]?.actionName === "image") {
        return "flex-none w-auto";
      }
      return "flex-1";
    },
    getValue(obj, key) {
      return get(obj, key);
    },
    formatDate(date) {
      return format(new Date(date), "dd.MM.yyyy HH:mm");
    },
    changeBox(event, iri) {
      if (event.target.checked) {
        this.selected.add(`${iri}`);
      } else {
        this.selected.delete(`${iri}`);
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
              search: this.searchString,
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
    handleResize() {
      this.isDesktop = window.innerWidth > 768;
    },
  },
  mounted() {
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize);
  },
  async created() {
    this.entryProcessor();
    await this.getItems();
    this.setUpBoxes();
  },
};
</script>

<style></style>
