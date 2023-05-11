<template>
  <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
    <h2 class="font-extrabold text-4xl">Sections</h2>
  </div>
  <div
    :class="`flex ${itemsSelected ? 'justify-between' : 'justify-end'} mb-2`"
  >
    <button
      v-if="itemsSelected"
      @click="deleteSections"
      class="bg-white p-1 rounded-l-lg"
    >
    <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
    </button>

    <button class="rounded-r-lg bg-white p-1" @click="createSection">
      <font-awesome-icon :icon="icons.faPlus" class="h-6 w-6 text-gray-500" />
    </button>
  </div>
  <Table
    :key="tableKey"
    entity="sections"
    @changeSelected="changeSelected"
    titles="Name,From Age,To Age"
    columns="name:link(id),fromAge,toAge"
  />
</template>

<script>
import Table from "../../components/admin/Table.vue";
import { faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
  components: { Table},
  data() {
    return {
      content: undefined,
      selected: [],
      tableKey: 0,
      icons: {
        faTrash,
        faPlus
      }
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
    async deleteSections() {
      try {
        await Promise.all(
          this.selected.map(async (section) => {
            await this.callApi("delete", section);
          })
        );
        this.tableKey++;
        this.$store.dispatch(
          "notification/notify",
          "All selected Sections were deleted"
        );
      } catch (e) {
        console.log(e);
      }
    },
    async createSection() {
      try {
        const response = await this.callApi("post", "/sections", {
          name: "",
          fromAge: 0,
          toAge: 0,
        });
        this.$router.push({ name: "Section", params: { id: response.data.id } });
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style>
</style>