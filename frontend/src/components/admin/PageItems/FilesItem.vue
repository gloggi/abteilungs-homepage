<template>
    <DragItemBox :boxTitle="boxTitle" :item="item" @delete="event=>$emit('delete', event)" @startedDragging="$emit('startedDragging')" @endedDragging="$emit('endedDragging')" >
    <Card class="space-y-2">
        <TextInput v-model="item.title" label="Title" />
      <FilesSelector :item="item" @changeImages="changeImages" />
      </Card>
  </DragItemBox>
  </template>
  
  <script>
  import { faXmark, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
  import DragItemBox from '../DragItemBox.vue';
  import FilesSelector from '../FilesSelector.vue';
  import Card from "../Card.vue";
import TextInput from "../TextInput.vue";
  
  export default {
    components: { DragItemBox, FilesSelector, Card, TextInput },
    props: ["item", "modelValue", "boxTitle"],
    emits: ["updatePage", "changeImages","delete", "startedDragging", "endedDragging"],
    data() {
      return {
        imageItem: undefined,
        showModal: false,
        preSelectedImages: undefined,
        selectedImages: undefined,
        icons: {
          faXmark,
          faTrash,
          faPlus
        }
      };
    },
    methods: {
      selectHandler(selectedImages) {
        this.preSelectedImages = selectedImages;
        this.$emit("changeImages", { id: this.item.id, files: selectedImages })
      },
      removeSelectedImage(image) {
        this.preSelectedImages = this.preSelectedImages.filter(i => i.id !== image.id)
        this.selectHandler(this.preSelectedImages)
      },
  
    },
    computed: {
    },
    created() {
      this.preSelectedImages = this.item.files
  
    },
  
  }
  </script>
  
  <style></style>