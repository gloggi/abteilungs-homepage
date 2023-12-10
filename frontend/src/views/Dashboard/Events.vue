<template>
    <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
      <h2 class="font-extrabold text-4xl">Events</h2>
    </div>
    <div
      :class="`flex ${itemsSelected ? 'justify-between' : 'justify-end'} mb-2`"
    >
      <button
        v-if="itemsSelected"
        @click="deleteEvents"
        class="bg-white p-1 rounded-l-lg"
      >
      <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
      </button>
  
      <button class="rounded-r-lg bg-white p-1" @click="createEvent">
        <font-awesome-icon :icon="icons.faPlus" class="h-6 w-6 text-gray-500" />
      </button>
    </div>
    <Table
      :key="tableKey"
      entity="events"
      @changeSelected="changeSelected"
      titles="Title,Start,End"
      columns="title:link(id),startTime,endTime"
    />
  </template>
  
  <script>
  import Table from "../../components/admin/Table.vue";
  import { faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
  export default {
    components: { Table },
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
      async deleteEvents() {
        try {
          await Promise.all(
            this.selected.map(async (event) => {
              await this.callApi("delete", `events/${event}`);
            })
          );
          this.selected = []
          this.tableKey++;
          this.$store.dispatch(
            "notification/notify",
            "All selected Events were deleted"
          );
        } catch (e) {
          console.log(e);
        }
      },
      async createEvent() {
        try {
          const response = await this.callApi("post", "/events", {
            
          });
          this.$router.push({ name: "Event", params: { id: response.data.id } });
        } catch (e) {
          console.log(e);
        }
      },
    },
  };
  </script>
  
  <style>
  </style>