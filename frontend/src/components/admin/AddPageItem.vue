<template>
  <button
    @click="showModal = true"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    class="rounded-lg my-1 h-1.5 w-full text-xs hover:text-white"
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
        class="flex flex-col bg-gray-200 hover:bg-gray-300 rounded-lg p-3 space-y-2 text-gray-200 hover:text-gray-300"
      >
        <div
          class="aspect-square bg-white rounded-lg flex justify-center items-center"
        >
          <TextItem class="h-full w-full" v-if="field.type === 'textItem'" />
          <ImageItem
            class="h-full w-full"
            v-else-if="field.type === 'imageItem'"
          />
          <FormItem
            class="h-full w-full"
            v-else-if="field.type === 'formItem'"
          />
          <FilesItem
            class="h-full w-full"
            v-else-if="field.type === 'filesItem'"
          />
          <ContactItem
            class="h-full w-full"
            v-else-if="field.type === 'contactItem'"
          />
          <GroupsItem
            class="h-full w-full"
            v-else-if="field.type === 'groupsItem'"
          />
          <SectionsItem
            class="h-full w-full"
            v-else-if="field.type === 'sectionsItem'"
          />
          <CampItem
            class="h-full w-full"
            v-else-if="field.type === 'campItem'"
          />
          <LocationItem
            class="h-full w-full"
            v-else-if="field.type === 'locationItem'"
          />
          <FaqItem class="h-full w-full" v-else-if="field.type === 'faqItem'" />
          <GroupEventsItem
            class="h-full w-full"
            v-else-if="field.type === 'groupEventsItem'"
          />
          <p v-else class="font-serif text-8xl">
            {{ field.name.substring(0, 1) }}
          </p>
        </div>
        <p class="font-semibold pl-1 md:pl-5 break-words text-black">
          {{ field.name }}
        </p>
      </div>
    </div>
  </Modal>
</template>
<script>
import Modal from "./Modal.vue";
import TextItem from "../../assets/PageItems/TextItem.svg?component";
import ImageItem from "../../assets/PageItems/ImageItem.svg?component";
import FormItem from "../../assets/PageItems/FormItem.svg?component";
import FilesItem from "../../assets/PageItems/FilesItem.svg?component";
import ContactItem from "../../assets/PageItems/ContactItem.svg?component";
import GroupsItem from "../../assets/PageItems/GroupsItem.svg?component";
import SectionsItem from "../../assets/PageItems/SectionsItem.svg?component";
import CampItem from "../../assets/PageItems/CampItem.svg?component";
import LocationItem from "../../assets/PageItems/LocationItem.svg?component";
import FaqItem from "../../assets/PageItems/FaqItem.svg?component";
import GroupEventsItem from "../../assets/PageItems/GroupEventsItem.svg?component";

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
        },
        {
          name: this.$t("dashboard.image"),
          type: "imageItem",
        },
        {
          name: this.$t("dashboard.form"),
          type: "formItem",
        },
        {
          name: this.$t("dashboard.files"),
          type: "filesItem",
        },
        {
          name: this.$t("dashboard.contacts"),
          type: "contactItem",
        },
        {
          name: this.$t("dashboard.groups"),
          type: "groupsItem",
        },
        {
          name: this.$t("dashboard.sections"),
          type: "sectionsItem",
        },
        {
          name: this.$t("dashboard.camps"),
          type: "campItem",
        },
        {
          name: this.$t("dashboard.location"),
          type: "locationItem",
        },
        {
          name: this.$t("dashboard.faq"),
          type: "faqItem",
        },
        {
          name: this.$t("dashboard.groupEvents"),
          type: "groupEventsItem",
        },
      ],
    };
  },
  computed: {
    isDragging() {
      return this.$store.state.drag.dragging;
    },
  },
  components: {
    Modal,
    TextItem,
    ImageItem,
    FormItem,
    FilesItem,
    ContactItem,
    GroupsItem,
    SectionsItem,
    CampItem,
    LocationItem,
    FaqItem,
    GroupEventsItem,
  },
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
