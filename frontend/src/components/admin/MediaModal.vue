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
      />
    </div>

    <template #footer>
      <div class="flex items-center justify-between gap-3 pt-4 border-t border-gray-200">
        <p class="text-sm text-gray-500">
          {{ selected.length }} {{ $t('dashboard.selected') }}
        </p>
        <div class="flex items-center gap-2">
          <ButtonComponent
            @click="close"
            variant="ghost"
            size="default"
          >
            {{ $t('dashboard.cancel') }}
          </ButtonComponent>
          <ButtonComponent
            @click="selectAndClose"
            variant="default"
            size="default"
            :disabled="selected.length === 0"
          >
            <font-awesome-icon :icon="icons.faCheck" class="h-3.5 w-3.5 mr-2" />
            {{ $t('dashboard.confirm') }}
          </ButtonComponent>
        </div>
      </div>
    </template>
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
