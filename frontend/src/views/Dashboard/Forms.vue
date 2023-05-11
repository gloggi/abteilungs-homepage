<template>
    <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
      <h2 class="font-extrabold text-4xl">Forms</h2>
    </div>
    <div
      :class="`flex ${itemsSelected ? 'justify-between' : 'justify-end'} mb-2`"
    >
      <button
        v-if="itemsSelected"
        @click="deleteForms"
        class="bg-white p-1 rounded-l-lg"
      >
        <TrashIcon class="h-6 w-6 text-gray-500" />
      </button>
  
      <button class="rounded-r-lg bg-white p-1" @click="createGroup">
        <PlusIcon class="h-6 w-6 text-gray-500" />
      </button>
    </div>
    <Table
      :key="tableKey"
      entity="forms"
      @changeSelected="changeSelected"
      titles="Name,E-Mail"
      columns="name:link(id),email"
    />
  </template>
  
  <script>
  import Table from "../../components/admin/Table.vue";
  import { TrashIcon, PlusIcon } from "@heroicons/vue/24/solid";
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
      async deleteForms() {
        try {
          await Promise.all(
            this.selected.map(async (group) => {
              await this.callApi("delete", `forms/${group}`);
            })
          );
          this.tableKey++;
          this.$store.dispatch(
            "notification/notify",
            "All selected Forms were deleted"
          );
        } catch (e) {
          console.log(e);
        }
      },
      async createGroup() {
        try {
          const response = await this.callApi("post", "/forms", {
            name: ""
          });
          this.$router.push({ name: "Group", params: { id: response.data.id } });
        } catch (e) {
          console.log(e);
        }
      },
    },
  };
  </script>
  
  <style>
  </style>