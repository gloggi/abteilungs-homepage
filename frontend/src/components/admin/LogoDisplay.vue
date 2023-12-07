<template>
<div class="relative">
    <div class="rounded-full h-48 w-48 border aspect-square bg-gray-200">
      <img v-if="file" :src="`${backendURL}${file.thumbnail}`" class="object-cover" />
  </div>
    <div class="absolute top-3 right-3 flex justify-center items-center">
      <button @click="showModal=true" class="rounded-full w-7  aspect-square bg-white border">
        <font-awesome-icon :icon="icons.faPencil" class="text-gray-700 h-4 w-4"/>
      </button>
    </div>
  </div>
  <MediaModal v-if="showModal" @close="closeHandler" @select="selectHandler" :max-select="1"/>
</template>
<script>

import MediaModal from "../../components/admin/MediaModal.vue";
import { faPencil } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {  MediaModal },
    emits: ["selectImage"],
    props: ["logo"],
    data(){
      return {
        showModal: false,
        fileId: undefined,
        file: this.logo,
        icons: {
          faPencil
        }

      }
    },
    methods:{
      closeHandler(){
        this.showModal = false
      },
      async selectHandler(selected){
        const file = selected[0];
        this.$emit("selectImage", file)
        const response = await this.callApi(
          "get",
          `/files/${file.id}`
        );
        this.file = response.data;

      }

    }
}
</script>