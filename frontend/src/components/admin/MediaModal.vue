<template>
  <Modal @close="handleClose" title="Bilder">
    <div class="overflow-y-scroll absolute top-5 left-5 right-5 bottom-5">
    <DragAndDropUpload @uploadedFile="getMedia" />
    <div class=" p-1 grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2" :key="listKey">
        
            <div @click="()=>select(file['@id'])" v-for="file in content" :key="file['@id']" :class="`bg-gray-50 rounded-lg h-full ${selectedValues[file['@id']]?'ring-offset-2 ring ring-purple-500':''}`">
                <img :src="file.contentUrl" class="rounded-lg object-cover h-full" />
            </div>
    </div>
    </div>
    <template v-slot:footer>
    <div class="absolute bottom-5 right-5 justify-end mt-2 px-5"><Button @click="handleSelected">Add</Button></div>
  </template>
  </Modal>
</template>

<script>
import Button from './Button.vue';
import DragAndDropUpload from './DragAndDropUpload.vue';
import Modal from "./Modal.vue";
export default {
  components: { Modal, Button, DragAndDropUpload },
  emits: ["close", "selectImages"],
  props:["preselected"],
  data() {
    return {
      content: undefined,
      selected: new Set([]),
      selectedValues:{}
    };
  },
  methods: {
    handleSelected(){
      this.$emit("selectImages", Array.from(this.selected))
      this.$emit("close")
    },
    select(iri){
      if(this.selectedValues[iri]){
        this.selectedValues[iri] = false
        this.selected.delete(iri)
      }else{
        this.selectedValues[iri] = true
        this.selected.add(iri)

      }

    },
    setUpBoxes(){
          this.content.forEach((item)=>{
            if(!this.preselected.includes(item["@id"])){
              this.selectedValues[item["@id"]] = false
              }else{
                this.selectedValues[item["@id"]] = true
              }
          })
      },
    handleClose() {
      this.$emit("close", true);
    },
    async getMedia() {
      try {
        const response = await this.callApi("get", "/media_objects?type=image");
        this.content = response.data["hydra:member"];
        this.listKey++;
      } catch (e) {
        console.log(e);
      }
    },
  },
  async created(){
    await this.getMedia()
    this.selected= new Set(this.preselected)
    this.setUpBoxes()
  }
};
</script>

<style></style>
