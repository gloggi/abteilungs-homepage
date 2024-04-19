<template>
  <Modal @close="close" class="overflow-y-scroll">
    <div class="flex flex-col space-y-2">
      <h1 class="text-4xl font-bold pb-2">{{ $t("dashboard.files") }}</h1>
      <DragAndDropUpload @uploadedFile="gridKey++" />

      <SelectMediaGrid
        class="overflow-y-scroll"
        style="max-height: 65vh"
        :key="gridKey"
        :extensions="extensions"
        :maxSelect="maxSelect"
        :category="category"
        :pre-selected="preSelected"
        @selectItems="selectItemsHandler"
      />
      <div class="pt-3 w-full flex justify-end h-13">
        <ActionButton
          :reverse="true"
          @click="selectAndClose"
          :toolTipText="$t('dashboard.selectAndClose')"
        >
          <font-awesome-icon :icon="icons.faCheck" class="h-6 w-6" />
        </ActionButton>
      </div>
    </div>
  </Modal>
</template>

<script>
import DragAndDropUpload from "./DragAndDropUpload.vue";
import Modal from "./Modal.vue";
import SelectMediaGrid from "./SelectMediaGrid.vue";
import { faCheck } from "@fortawesome/free-solid-svg-icons";
import ActionButton from "./ActionButton.vue";
export default {
  components: { Modal, DragAndDropUpload, SelectMediaGrid, ActionButton },
  emits: ["close", "select"],
  props: {
    category: {
      type: String,
      default: "general",
    },
    maxSelect: {
      type: Number,
      default: 1,
    },
    preSelected: {
      type: Array,
      default: () => [],
    },
    extensions: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      selected: [],
      gridKey: 0,
      icons: {
        faCheck,
      },
    };
  },
  methods: {
    selectItemsHandler(selected) {
      this.selected = selected;
    },
    selectAndClose() {
      this.$emit("select", this.selected);
      this.close();
    },
    close() {
      this.$emit("close", true);
    },
  },
  async created() {},
};
</script>

<style></style>
