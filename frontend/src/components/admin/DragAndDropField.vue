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
      }  border-2 border-gray-400 border-dashed text-center p-5`"
    >
      <font-awesome-icon
        :icon="icons.faFileCirclePlus"
        class="h-12 w-12 text-gray-400"
      />

      <div class="flex items-center">
        <label
          for="file-upload"
          class="text-sm font-medium text-gray-900 hover:text-gray-700"
          >Upload a File
          <input
            id="file-upload"
            type="file"
            class="sr-only"
            multiple
            @change="uploadFile"
          />
        </label>
        <div class="text-sm">&nbsp;{{ $t("dashboard.dragAndDrop") }}</div>
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
