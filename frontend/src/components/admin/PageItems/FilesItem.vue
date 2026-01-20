<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card class="space-y-2">
      <div class="flex flex-row gap-4">
        <TextInput
          v-model="titleValue"
          :label="$t('dashboard.title')"
          id="title"
          class="flex-grow"
        />
        <SelectComponent
          id="viewMode"
          :label="$t('dashboard.viewMode')"
          :options="viewModes"
          :value="viewModeValue"
          :returnInt="false"
          selection="ViewMode"
          class="w-1/4"
          @selectViewMode="handleViewModeChange"
        />
      </div>
      <FilesSelector :item="item" @changeFiles="handleFilesChange" />
    </Card>
  </DragItemBox>
</template>

<script>
import { faXmark, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import DragItemBox from "../DragItemBox.vue";
import FilesSelector from "../FilesSelector.vue";
import Card from "../Card.vue";
import TextInput from "../TextInput.vue";
import SelectComponent from "../SelectComponent.vue";

export default {
  components: { DragItemBox, FilesSelector, Card, TextInput, SelectComponent },
  props: ["title", "item", "modelValue", "boxTitle"],
  emits: [
    "updatePage",
    "changeFiles",
    "delete",
    "startedDragging",
    "endedDragging",
    "update:title",
  ],
  data() {
    return {
      imageItem: undefined,
      showModal: false,
      preSelectedImages: undefined,
      selectedImages: undefined,
      icons: {
        faXmark,
        faTrash,
        faPlus,
      },
      viewModes: [
        { id: "gallery", name: "Galerie" },
        { id: "list", name: "Liste" },
      ],
    };
  },
  methods: {
    selectHandler(selectedImages) {
      this.preSelectedImages = selectedImages;
      this.$emit("changeImages", { id: this.item.id, files: selectedImages });
    },
    removeSelectedImage(image) {
      this.preSelectedImages = this.preSelectedImages.filter(
        (i) => i.id !== image.id,
      );
      this.selectHandler(this.preSelectedImages);
    },
    handleFilesChange(event) {
      event.viewMode = this.viewModeValue;
      event.title = this.title;
      this.$emit("changeFiles", event);
    },
    handleViewModeChange(viewMode) {
      if (!viewMode) return;
      this.$emit("changeFiles", {
        id: this.item.id,
        files: this.item.files,
        title: this.title,
        viewMode: viewMode,
      });
    },
  },
  created() {
    this.preSelectedImages = this.item.files;
  },
  computed: {
    titleValue: {
      get() {
        return this.title;
      },
      set(value) {
        this.$emit("update:title", value);
      },
    },
    viewModeValue() {
      return this.item.viewMode || "gallery";
    },
  },
};
</script>

<style></style>
