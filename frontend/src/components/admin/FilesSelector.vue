<template>
  <div>
    <div class="flex flex-wrap space-x-2 gap-2">
      <div v-for="(image, i) in preSelectedImages" :key="i" class="relative">
        <button
          @click="removeSelectedImage(image)"
          class="absolute bottom-1 right-1"
        >
          <font-awesome-icon :icon="icons.faTrash" class="w-3 p-1 text-white" />
        </button>
        <img
          :src="`${backendURL}${image.thumbnail}`"
          class="h-48 object-cover rounded-md"
          style="aspect-ratio: 1/1.414"
        />
      </div>
      <button
        @click="showModal = true"
        class="rounded-md border border-gray-200 flex justify-center items-center h-48"
        style="aspect-ratio: 1/1.414"
      >
        <font-awesome-icon
          :icon="icons.faPlus"
          class="h-6 w-6 p-5 text-gray-500"
        />
      </button>
    </div>
    <InfoField v-if="info" :info="info" />
    <MediaModal
      v-if="showModal"
      @close="showModal = false"
      :extensions="['pdf', 'docx', 'xlsx', 'pptx', 'zip', 'mp3', 'mp4']"
      :pre-selected="preSelectedImages"
      @select="selectHandler"
      :max-select="1000"
    />
  </div>
</template>

<script>
import { faXmark, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";

import MediaModal from "./MediaModal.vue";
import InfoField from "./InfoField.vue";

export default {
  components: { MediaModal, InfoField },
  props: ["item", "modelValue", "info"],
  emits: ["changeFiles"],
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
      this.$emit("changeFiles", { id: this.item.id, files: selectedImages });
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
    const files = this.item.files;
    this.preSelectedImages = files ? [...files] : [];
  },
};
</script>

<style></style>
