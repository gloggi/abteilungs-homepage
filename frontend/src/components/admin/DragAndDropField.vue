<template>
  <div
    @dragover.prevent
    @dragenter="isDragging = true"
    @dragleave="isDragging = false"
    @drop.prevent
    @drop="dropFile"
  >
    <div
      :class="`flex flex-col justify-center items-center rounded-lg ${
        isDragging ? 'bg-gray-50' : ''
      }  border-2 border-gray-400 border-dashed text-center p-5 relative `"
    >
      <label for="file-upload" class="absolute z-10 inset-0 cursor-pointer">
        <input
          id="file-upload"
          type="file"
          class="sr-only"
          multiple
          @change="uploadFile"
        />
      </label>
      <font-awesome-icon
        :icon="icons.faFileCirclePlus"
        class="h-12 w-12 text-gray-400"
      />

      <div class="flex items-center text-xs md:text-sm">
        <p>
          <span class="font-medium text-gray-900 hover:text-gray-700">{{
            $t("dashboard.uploadFile")
          }}</span>
          {{ $t("dashboard.dragAndDrop") }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { faFileCirclePlus } from "@fortawesome/free-solid-svg-icons";
export default {
  emits: ["droppedFile"],
  data() {
    return {
      isDragging: false,
      icons: {
        faFileCirclePlus,
      },
    };
  },
  methods: {
    uploadFile(e) {
      const files = e.target.files;
      this.handleFiles(files);
    },
    dropFile(e) {
      this.isDragging = false;
      const files = e.dataTransfer.files;
      this.handleFiles(files);
    },
    handleFiles(files) {
      for (let file of files) {
        this.$emit("droppedFile", file);
      }
    },
  },
};
</script>

<style></style>
