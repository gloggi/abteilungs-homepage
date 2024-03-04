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
    <span v-if="dragging">{{ $t("dashboard.dropFormItemHere") }}</span>
    <span v-else>
      <font-awesome-icon :icon="icons.faPlus" />
      {{ $t("dashboard.clickToAddFormItem") }}
    </span>
  </button>
  <Modal v-if="showModal" @close="close">
    <h1 class="text-4xl font-bold pb-2">{{ $t("dashboard.formFields") }}</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
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
        <p class="font-semibold pl-1 md:pl-5">{{ field.name }}</p>
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
      showModal: false,
      increaseHeight: false,
      icons: {
        faPlus: faPlus,
      },
      fields: [
        {
          name: this.$t("dashboard.textfield"),
          type: "textField",
          inputType: "text",
          src: this.getAsset("FormFields/Textfield.svg"),
        },
        {
          name: this.$t("dashboard.numberfield"),
          type: "textField",
          inputType: "number",
          src: this.getAsset("FormFields/Numberfield.svg"),
        },
        {
          name: this.$t("dashboard.datefield"),
          type: "textField",
          inputType: "date",
          src: this.getAsset("FormFields/Datefield.svg"),
        },
        {
          name: this.$t("dashboard.timefield"),
          type: "textField",
          inputType: "time",
          src: this.getAsset("FormFields/Timefield.svg"),
        },
        {
          name: this.$t("dashboard.email"),
          type: "textField",
          inputType: "email",
          src: this.getAsset("FormFields/Emailfield.svg"),
        },
        {
          name: this.$t("dashboard.textareafield"),
          type: "textareaField",
          src: this.getAsset("FormFields/Textareafield.svg"),
        },
        {
          name: this.$t("dashboard.selectfield"),
          type: "selectField",
          src: this.getAsset("FormFields/Selectfield.svg"),
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
