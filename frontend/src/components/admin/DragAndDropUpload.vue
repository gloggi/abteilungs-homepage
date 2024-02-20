<template>
  <div
    @dragover.prevent
    @dragenter="isDragging = true"
    @dragleave="isDragging = false"
    @drop.prevent
    @drop="dragFile"
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
          class="text-sm font-medium text-blue-600 hover:text-blue-800"
          >{{ text }}
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
  emits: ["uploadedFile"],
  props: {
    category: { default: "general" },
    text: { default: "Upload a File" },
  },
  data() {
    return {
      files: [],
      isDragging: false,
      icons: {
        faFileCirclePlus,
      },
    };
  },
  methods: {
    async addMedia() {
      try {
        for (const file of this.files) {
          let formData = new FormData();
          formData.append("file", file, file.name);
          formData.append("category", this.category);
          await this.callApi("post", "/files", formData);
        }
        this.files = [];
        this.$emit("uploadedFile", true);
      } catch (e) {
        console.log(e);
      }
    },
    uploadFile(e) {
      this.files = e.target.files;
      this.addMedia();
    },
    dragFile(e) {
      this.isDragging = false;
      this.files = e.dataTransfer.files;
      this.addMedia();
    },
  },
};
</script>

<style></style>
