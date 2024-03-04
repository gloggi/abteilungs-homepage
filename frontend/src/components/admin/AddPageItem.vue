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
    <span v-if="dragging">{{ $t("dashboard.dropPageItemHere") }}</span>
    <span v-else>
      <font-awesome-icon :icon="icons.faPlus" />
      {{ $t("dashboard.clickToAddPageItem") }}
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
        class="flex flex-col bg-gray-200 hover:bg-gray-300 rounded-lg p-3 space-y-2"
      >
        <div
          class="aspect-square bg-white rounded-lg flex justify-center items-center"
        >
          <img class="h-full w-full" v-if="field.src" :src="field.src" />
          <p v-else class="font-serif text-8xl">
            {{ field.name.substring(0, 1) }}
          </p>
        </div>
        <p class="font-semibold pl-1 md:pl-5 break-words">{{ field.name }}</p>
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
        {
          name: this.$t("dashboard.text"),
          type: "textItem",
          src: this.getAsset("PageItems/TextItem.svg"),
        },
        {
          name: this.$t("dashboard.image"),
          type: "imageItem",
          src: this.getAsset("PageItems/ImageItem.svg"),
        },
        {
          name: this.$t("dashboard.form"),
          type: "formItem",
          src: this.getAsset("PageItems/FormItem.svg"),
        },
        {
          name: this.$t("dashboard.files"),
          type: "filesItem",
          src: this.getAsset("PageItems/FilesItem.svg"),
        },
        {
          name: this.$t("dashboard.contacts"),
          type: "contactItem",
          src: this.getAsset("PageItems/ContactItem.svg"),
        },
        {
          name: this.$t("dashboard.groups"),
          type: "groupsItem",
          src: this.getAsset("PageItems/GroupsItem.svg"),
        },
        {
          name: this.$t("dashboard.sections"),
          type: "sectionsItem",
          src: this.getAsset("PageItems/SectionsItem.svg"),
        },
        {
          name: this.$t("dashboard.camps"),
          type: "campsItem",
          src: this.getAsset("PageItems/CampsItem.svg"),
        },
        {
          name: this.$t("dashboard.location"),
          type: "locationItem",
          src: this.getAsset("PageItems/LocationItem.svg"),
        },
        {
          name: this.$t("dashboard.faq"),
          type: "faqItem",
          src: this.getAsset("PageItems/FaqItem.svg"),
        },
        {
          name: this.$t("dashboard.groupEvents"),
          type: "groupEventsItem",
          src: this.getAsset("PageItems/GroupEventsItem.svg"),
        },
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
