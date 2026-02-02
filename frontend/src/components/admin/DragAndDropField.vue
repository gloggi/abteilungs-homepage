<template>
  <div
    class="w-full"
    @dragover.prevent
    @dragenter="isDragging = true"
    @dragleave="isDragging = false"
    @drop.prevent
    @drop="dropFile"
  >
    <div
      :class="[
        'relative flex flex-col items-center justify-center w-full rounded-lg border-2 border-dashed px-6 py-10 transition-colors duration-200 ease-in-out',
        isDragging
          ? 'border-gray-400 bg-gray-50'
          : 'border-gray-200 bg-white hover:bg-gray-50 hover:border-gray-300',
      ]"
    >
      <label
        for="file-upload"
        class="absolute inset-0 w-full h-full cursor-pointer z-10"
      >
        <input
          id="file-upload"
          type="file"
          class="sr-only"
          multiple
          @change="uploadFile"
        />
      </label>

      <div
        class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 ring-8 ring-gray-50"
      >
        <font-awesome-icon
          :icon="icons.faFileCirclePlus"
          class="h-6 w-6 text-gray-600"
        />
      </div>

      <div class="space-y-1 text-center">
        <p class="text-sm font-medium text-gray-700">
          <span class="font-semibold">
            {{ $t("dashboard.uploadFile") }}
          </span>
        </p>
        <p class="text-xs text-gray-500">
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
