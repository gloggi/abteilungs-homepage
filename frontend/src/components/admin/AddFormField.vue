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
        class="flex flex-col bg-gray-200 hover:bg-gray-300 rounded-lg p-3 space-y-2 text-gray-200 hover:text-gray-300"
      >
        <div
          class="aspect-square bg-white rounded-lg flex justify-center items-center"
        >
          <Textfield class="h-full w-full" v-if="field.type === 'textField'" />
          <Numberfield
            class="h-full w-full"
            v-else-if="field.type === 'numberField'"
          />
          <Datefield
            class="h-full w-full"
            v-else-if="field.type === 'dateField'"
          />
          <Timefield
            class="h-full w-full"
            v-else-if="field.type === 'timeField'"
          />
          <Emailfield
            class="h-full w-full"
            v-else-if="field.type === 'emailField'"
          />
          <Textareafield
            class="h-full w-full"
            v-else-if="field.type === 'textareaField'"
          />
          <Selectfield
            class="h-full w-full"
            v-else-if="field.type === 'selectField'"
          />
          <p v-else class="font-serif text-8xl">
            {{ field.name.substring(0, 1) }}
          </p>
        </div>
        <p class="font-semibold pl-1 md:pl-5 text-black">{{ field.name }}</p>
      </div>
    </div>
  </Modal>
</template>
<script>
import Modal from "./Modal.vue";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import Textfield from "../../assets/FormFields/Textfield.svg?component";
import Numberfield from "../../assets/FormFields/Numberfield.svg?component";
import Datefield from "../../assets/FormFields/Datefield.svg?component";
import Timefield from "../../assets/FormFields/Timefield.svg?component";
import Emailfield from "../../assets/FormFields/Emailfield.svg?component";
import Textareafield from "../../assets/FormFields/Textareafield.svg?component";
import Selectfield from "../../assets/FormFields/Selectfield.svg?component";

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
        },
        {
          name: this.$t("dashboard.numberfield"),
          type: "textField",
          inputType: "number",
        },
        {
          name: this.$t("dashboard.datefield"),
          type: "textField",
          inputType: "date",
        },
        {
          name: this.$t("dashboard.timefield"),
          type: "textField",
          inputType: "time",
        },
        {
          name: this.$t("dashboard.email"),
          type: "textField",
          inputType: "email",
        },
        {
          name: this.$t("dashboard.textareafield"),
          type: "textareaField",
        },
        {
          name: this.$t("dashboard.selectfield"),
          type: "selectField",
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
    Textfield,
    Numberfield,
    Datefield,
    Timefield,
    Emailfield,
    Textareafield,
    Selectfield,
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
