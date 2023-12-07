<template>
  <Card class="relative">
      <div class="absolute right-0 top-0">
          <button @click="deleteItem" class="border-l p-1 border-b border-gray-200 rounded-bl-lg">
            <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
            </button>
      </div>
        <div class="grid grid-cols-2 gap-2 mt-3">
          
        </div>
      <div class="flex justify-end mt-2">
        <Button @click="showModal=true"
            >Add Images</Button
          >
      </div>
      </Card>
      <MediaModal v-if="showModal" @close="showModal=false" @select="selectHandler" :max-select="2"/>
</template>

<script>
import MediaModal from '../MediaModal.vue';
import { faXmark, faTrash } from "@fortawesome/free-solid-svg-icons";
import Button from '../Button.vue';
import Card from '../Card.vue';

export default {
  components: { MediaModal, Button, Card },
    props: ["item"],
    emits: ["updatePage"],
  data() {
    return {
      imageItem: undefined,
      showModal: false,
      preSelectedImages: undefined,
      icons:{
        faXmark,
        faTrash
      }
    };
  },
  methods: {
    selectHandler(selectedImages){
      console.log(selectedImages)

    }
  
    
  },
  mounted() {
   
  },

}
</script>

<style>

</style>