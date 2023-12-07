<template>
  <Modal @close="close" title="Bilder">
    
    <DragAndDropUpload @uploadedFile="gridKey++" />
    <SelectMediaGrid :key="gridKey" :maxSelect="maxSelect" :category="category" @selectItems="selectItemsHandler" />
   
    
    <div v-if="selected.length>0" class="absolute  bottom-0 z-50 right-48 left-48 bg-gray-50  h-fit p-5 flex justify-end">
      
      <Button @click="selectAndClose">Auswählen</Button>
    </div>
  </Modal>
  
</template>

<script>
import Button from './Button.vue';
import DragAndDropUpload from './DragAndDropUpload.vue';
import Modal from "./Modal.vue";
import SelectMediaGrid from './SelectMediaGrid.vue';
export default {
  components: { Modal, Button, DragAndDropUpload, SelectMediaGrid },
  emits: ["close", "select"],
  props: {
        category: {
            type: String,
            default: "general"
        },
        maxSelect:{
            type: Number,
            default: 1
        }
    },
  data() {
    return {
     selected: [],
     gridKey: 0
    };
  },
  methods: {
    selectItemsHandler(selected){
      this.selected=selected
    },
    selectAndClose(){
      this.$emit("select", this.selected)
      this.close()
    },
    close(){
      this.$emit("close", true)
    }

  },
  async created(){
  
  }
};
</script>

<style></style>
