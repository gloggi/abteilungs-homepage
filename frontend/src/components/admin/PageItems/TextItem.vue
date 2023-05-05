<template>
  <Card v-if="textItem" class="relative">
    <div class="absolute right-0 top-0">
          <button @click="deleteItem" class="border-l p-1 border-b border-gray-200 rounded-bl-lg">
            <TrashIcon class="h-6 w-6 text-gray-500" />
            </button>
      </div>
    <TextInput  label="Title" v-model.lazy="textItem.title" />
    <Editor class="mt-2" v-model.lazy="textItem.body" />
  </Card>
</template>

<script>
import Card from "../Card.vue";
import Editor from "../Editor/Editor.vue";
import TextInput from "../TextInput.vue";
import {
  TrashIcon
} from "@heroicons/vue/24/solid";
export default {
  components: { TextInput, Editor, Card, TrashIcon },
  props: ["item"],
  emits: ["updatePage"],
  data() {
    return {
      textItem: undefined,
    };
  },
  methods: {
    change(){
      console.log("Change")
    },
    async deleteItem() {
      this.$store.commit("pageInEdit/updateItem", {id: this.textItem.id})
      this.notifyUser("Item was deleted")
    },
    
  },
  watch: {
    textItem: {
      handler: function(newVal, oldval) {
        if(!oldval){
          return
        }
        this.$store.commit("pageInEdit/updateItem",newVal)
        this.notifyUser("The Item was updated")
      },
      deep: true
    }
  },
  mounted() {
    this.textItem = {...this.item}
  },
};
</script>

<style>
</style>