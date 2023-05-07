<template>
<div class="relative">
    <div class="rounded-full h-48 w-48 border aspect-square bg-gray-200">
      <img v-if="file" :src="`http://localhost:8000${file.thumbnail}`" class="object-cover" />
  </div>
    <div class="absolute top-3 right-3 flex justify-center items-center">
      <button @click="showModal=true" class="rounded-full p-2 aspect-square bg-white border">
        <PencilIcon class="text-gray-700 h-4 w-4"/>
      </button>
    </div>
  </div>
  <MediaModal v-if="showModal" @close="closeHandler" @select="selectHandler" :max-select="1"/>
</template>
<script>
import { PencilIcon } from "@heroicons/vue/24/solid";
import MediaModal from "../../components/admin/MediaModal.vue";

export default {
    components: { PencilIcon, MediaModal },
    emits: ["selectImage"],
    props: ["logo"],
    data(){
      return {
        showModal: false,
        fileId: undefined,
        file: this.logo

      }
    },
    methods:{
      closeHandler(){
        this.showModal = false
      },
      async selectHandler(selected){
        const fileId = selected[0];
        this.$emit("selectImage", fileId)
        const response = await this.callApi(
          "get",
          `/files/${fileId}`
        );
        this.file = response.data;

      }

    }
}
</script>