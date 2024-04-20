<template>
  <DragAndDropField @droppedFile="handleDrop" />
</template>

<script>
import { faFileCirclePlus } from "@fortawesome/free-solid-svg-icons";
import DragAndDropField from "./DragAndDropField.vue";
export default {
  emits: ["uploadedFile"],
  props: {
    category: { default: "general" },
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
  props: {
    supportedFileTypes: {
      type: Array,
      default: () => [
        "image/jpeg",
        "image/png",
        "image/jpeg",
        "image/gif",
        "image/svg+xml",
        "application/pdf",
        "image/x-icon",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "audio/mpeg",
        "video/mp4",
        "application/zip",
      ],
    },
  },
  methods: {
    async handleDrop(file) {
      try {
        if (!this.supportedFileTypes.includes(file.type)) {
          this.notifyUser(this.$t("dashboard.fileExtensionNotSupported"), true);
          return;
        }
        const formData = new FormData();
        formData.append("file", file, file.name);
        formData.append("category", this.category);
        await this.callApi("post", "/files", formData);
        this.$emit("uploadedFile", true);
      } catch (e) {
        console.log(e);
        if (e.response.status === 422) {
          this.notifyUser(
            this.$t("dashboard.fileNotSupportedOrTooLarge"),
            true,
          );
        }
      }
    },
  },
  components: { DragAndDropField },
};
</script>

<style></style>
