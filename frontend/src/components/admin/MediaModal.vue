<template>
  <Modal @close="close" :title="$t('dashboard.files')" size="5xl">
    <div class="flex flex-col space-y-4">
      <DragAndDropUpload @uploadedFile="handleUpload" />

      <SelectMediaGrid
        :key="gridKey"
        :extensions="extensions"
        :maxSelect="maxSelect"
        :category="category"
        :pre-selected="preSelected"
        @selectItems="selectItemsHandler"
        class="pb-4"
      />

      <div
        class="sticky bottom-0 flex justify-end bg-white/95 py-4 backdrop-blur-xs border-t border-gray-100"
      >
        <ButtonComponent
          @click="selectAndClose"
        >
          <font-awesome-icon :icon="icons.faCheck" class="mr-2 h-4 w-4" />
          {{ $t("dashboard.selectAndClose") }}
        </ButtonComponent>
      </div>
    </div>
  </Modal>
</template>

<script>
import DragAndDropUpload from "./DragAndDropUpload.vue";
import Modal from "./Modal.vue";
import SelectMediaGrid from "./SelectMediaGrid.vue";
import ButtonComponent from "./ButtonComponent.vue";
import { faCheck } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { Modal, DragAndDropUpload, SelectMediaGrid, ButtonComponent },
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
    handleUpload() {
      this.gridKey++;
    },
  },
  created() {
    this.selected = this.preSelected || [];
  },
};
</script>

<style></style>
