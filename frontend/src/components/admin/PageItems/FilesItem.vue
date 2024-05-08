<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card class="space-y-2">
      <TextInput
        v-model="titleValue"
        :label="$t('dashboard.title')"
        id="title"
      />
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

export default {
  components: { DragItemBox, FilesSelector, Card, TextInput },
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
      event.title = this.title;
      this.$emit("changeFiles", event);
    },
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
  },
  created() {
    this.preSelectedImages = this.item.files;
  },
};
</script>

<style></style>
