<template>
  <button
    @click="showModal = true"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    class="rounded-lg my-1 h-1.5 w-full text-xs hover:text-white"
    :class="`${
      dragging
        ? 'bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500'
        : 'bg-gray-300 hover:bg-gray-400'
    } 
    ${increaseHeight ? 'h-48' : 'h-auto'}`"
  >
    <span v-if="dragging"> Drop page item here </span>
    <span v-else>
      <font-awesome-icon :icon="icons.faPlus" /> Click to add a new page item
    </span>
  </button>
  <Modal v-if="showModal" @close="close">
    <h1 class="text-4xl font-bold pb-2">{{ $t("dashboard.pageItems") }}</h1>
    <div
      class="grid grid-cols-2 md:grid-cols-4 gap-4 overflow-y-scroll"
      style="max-height: 65vh"
    >
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
import { faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
  data() {
    return {
      icons: {
        faPlus: faPlus,
      },
      showModal: false,
      increaseHeight: false,
      fields: [
        { name: this.$t("dashboard.text"), type: "textItem" },
        { name: this.$t("dashboard.image"), type: "imageItem" },
        { name: this.$t("dashboard.form"), type: "formItem" },
        { name: this.$t("dashboard.files"), type: "filesItem" },
        { name: this.$t("dashboard.contacts"), type: "contactItem" },
        { name: this.$t("dashboard.groups"), type: "groupsItem" },
        { name: this.$t("dashboard.sections"), type: "sectionsItem" },
        { name: this.$t("dashboard.camps"), type: "campsItem" },
        { name: this.$t("dashboard.location"), type: "locationItem" },
        { name: this.$t("dashboard.faq"), type: "faqItem" },
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
