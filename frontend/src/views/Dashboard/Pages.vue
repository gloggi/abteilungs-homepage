<template>
  <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
    <h2 class="font-extrabold text-4xl">Pages</h2>
  </div>
  <div
    :class="`flex ${itemsSelected ? 'justify-between' : 'justify-end'} mb-2`"
  >
    <button
      v-if="itemsSelected"
      @click="deletePages"
      class="bg-white p-1 rounded-l-lg"
    >
      <TrashIcon class="h-6 w-6 text-gray-500" />
    </button>

    <button class="rounded-r-lg bg-white p-1" @click="createPage">
      <PlusIcon class="h-6 w-6 text-gray-500" />
    </button>
  </div>
  <Table
    :key="tableKey"
    entity="pages"
    @changeSelected="changeSelected"
    titles="Titel,Permalink"
    columns="title:link(id),route"
  />
</template>

<script>
import Table from "../../components/admin/Table.vue";
import { TrashIcon, PlusIcon } from "@heroicons/vue/solid";
export default {
  components: { Table, TrashIcon, PlusIcon },
  data() {
    return {
      content: undefined,
      selected: [],
      tableKey: 0,
    };
  },
  computed: {
    itemsSelected() {
      return this.selected.length > 0;
    },
  },
  methods: {
    changeSelected(event) {
      this.selected = event;
    },
    async deletePages() {
      try {
        await Promise.all(
          this.selected.map(async (page) => {
            await this.callApi("delete", `pages/${page}`);
          })
        );
        this.selected = []
        this.tableKey++;
        this.$store.dispatch(
          "notification/notify",
          "All selected Pages were deleted"
        );
      } catch (e) {
        console.log(e);
      }
    },
    async createPage() {
      try {
        const response = await this.callApi("post", "/pages", {
          title: "Testpage",
          page_items: [],
          route: "",
        });
        this.$router.push({ name: "Page", params: { id: response.data.id } });
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style>
</style>