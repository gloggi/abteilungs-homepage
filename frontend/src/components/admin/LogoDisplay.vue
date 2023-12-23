<template>
<div class="relative">
    <div class="relative rounded-full h-48 w-48 border bg-gray-200 ">
      <img v-if="file" :src="`${backendURL}${file.thumbnail}`" class="aspect-square  h-full w-full rounded-full" :class="`${objectContain?'object-contain':'object-cover'}`" />
      <div class="absolute top-3 right-3 flex justify-center items-center">
      <button @click="showModal=true" class="rounded-full w-7  aspect-square bg-white border">
        <font-awesome-icon :icon="icons.faPencil" class="text-gray-700 h-4 w-4"/>
      </button>
    </div>
  </div>
    
  </div>
  <MediaModal v-if="showModal" :pre-selected="[logo]" :extensions="['jpg', 'png', 'gif', 'svg']" @close="closeHandler" @select="selectHandler" :max-select="1"/>
</template>
<script>

import MediaModal from "../../components/admin/MediaModal.vue";
import { faPencil } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {  MediaModal },
    emits: ["selectImage"],
    props: ["logo", "objectContain"],
    data(){
      return {
        showModal: false,
        fileId: undefined,
        file: undefined,
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
        
        if(selected.length>0){
          const file = selected[0];
          this.file=file
        }else{
          this.file = undefined
        }
        this.$emit("selectImage", this.file)

      }

    },
    created(){
      this.file = this.logo
    }
}
</script>