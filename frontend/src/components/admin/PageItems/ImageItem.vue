<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card>
      <BannerImageSelector :item="item" @changeImages="selectHandler" />
    </Card>
  </DragItemBox>
</template>

<script>
import { faXmark, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import DragItemBox from "../DragItemBox.vue";
import BannerImageSelector from "../BannerImageSelector.vue";
import Card from "../Card.vue";

export default {
  components: { DragItemBox, BannerImageSelector, Card },
  props: ["item", "modelValue", "boxTitle"],
  emits: [
    "updatePage",
    "changeImages",
    "delete",
    "startedDragging",
    "endedDragging",
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
  },
  computed: {},
  created() {
    this.preSelectedImages = this.item.files;
  },
};
</script>

<style></style>
