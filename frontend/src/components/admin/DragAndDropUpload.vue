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
  methods: {
    async handleDrop(file) {
      try {
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
