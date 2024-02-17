<template>
  <button
    @click="showModal = true"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    :class="`${
      dragging
        ? 'bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500'
        : 'bg-gray-300 hover:bg-gray-400'
    } 
    ${increaseHeight ? 'h-48' : 'h-1.5'}
    rounded-lg my-1 h-1.5 w-full text-xs`"
  ></button>
  <Modal v-if="showModal" @close="close">
    <h1 class="text-4xl font-bold pb-2">Page Items</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div
        v-for="field in fields"
        :key="field.type"
        @click="select(field)"
        class="flex flex-col bg-gray-200 hover:bg-gray-300 rounded-lg p-3"
      >
        <div
          class="aspect-square bg-white rounded-lg flex justify-center items-center"
        >
          <p class="font-serif text-8xl">{{ field.name.substring(0, 1) }}</p>
        </div>
        <p class="font-semibold pl-5">{{ field.name }}</p>
      </div>
    </div>
  </Modal>
</template>
<script>
import Modal from "./Modal.vue";

export default {
  data() {
    return {
      showModal: false,
      increaseHeight: false,
      fields: [
        { name: "Text", type: "textItem" },
        { name: "Image", type: "imageItem" },
        { name: "Form", type: "formItem" },
        { name: "Files", type: "filesItem" },
        { name: "Contact", type: "contactItem" },
        { name: "Groups", type: "groupsItem" },
        { name: "Sections", type: "sectionsItem" },
      ],
    };
  },
  computed: {
    isDragging() {
      return this.$store.state.drag.dragging;
    },
  },
  components: { Modal },
  props: ["sortKey", "dragging"],
  emits: ["select", "changeOrder"],
  methods: {
    handleDrop(e) {
      this.increaseHeight = false;
      const field = JSON.parse(e.dataTransfer.getData("text"));
      field.sort = this.sortKey + 0.5;
      this.$emit("changeOrder", field);
    },
    close() {
      this.showModal = false;
    },
    select(field) {
      this.$emit("select", { ...field, sort: this.sortKey + 0.5 });
      this.showModal = false;
    },
  },
};
</script>
