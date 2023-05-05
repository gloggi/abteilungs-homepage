<template>
  <div
    @dragover.prevent
    @dragenter="isDragging = true"
    @dragleave="isDragging = false"
    @drop.prevent
    @drop="dragFile"
    :class="`flex flex-col justify-center items-center rounded-lg ${
      isDragging ? 'bg-gray-50' : ''
    }  border-2 border-gray-400 border-dashed text-center p-5`"
  >
      <DocumentAddIcon class="h-12 w-12 text-gray-400" />
     <div class="flex items-center">
          <label for="file-upload" class="text-sm font-medium text-blue-600 hover:text-blue-800">Upload a File
               <input id="file-upload" type="file" class="sr-only" multiple @change="uploadFile"/> </label>
          <div class="text-sm">&nbsp;or drag and drop</div>
     </div>
  </div>
</template>

<script>
import { DocumentAddIcon } from "@heroicons/vue/24/solid";
export default {
  components: { DocumentAddIcon },
  emits:["uploadedFile"],
  data() {
    return {
      files: [],
      isDragging: false,
    };
  },
  methods: {
    async addMedia() {
      try {
        const formData = new FormData();
        for(const file of this.files){
        formData.append("file", file, file.name);
        formData.append("category", "general")
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
      this.addMedia()
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
