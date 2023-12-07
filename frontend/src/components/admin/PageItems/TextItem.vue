<template>
  <Card class="p-0 space-y-2">
    <div class="px-5 pt-5">
    <TextInput  label="Title" v-model.lazy="titleValue" />
    <Editor class="mt-2" v-model.lazy="bodyValue" />
  </div>
  <hr/>
  <div class="flex justify-end space-x-2 px-5 pb-5 text-gray-500">
    <button @click="deleteItem"><font-awesome-icon :icon="icons.faTrash"/> </button>

  </div>

  </Card>
</template>

<script>
import Card from "../Card.vue";
import Editor from "../Editor/Editor.vue";
import TextInput from "../TextInput.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
export default {
  components: { TextInput, Editor, Card },
  props: [ "title", "body", "item"],
  emits: ["updatePage", "update:title", "update:body", "delete"],
  data() {
    return {
      textItem: undefined,
      icons:{
        faTrash
      }
    };
  },
  methods: {
    change(){
      console.log("Change")
    },
    async deleteItem() {
     this.$emit("delete", this.item.type+this.item.id)
    },
    
  },
  computed: {
    titleValue: {
      get() {
        return this.title;
      },
      set(value) {
        this.$emit("update:title", value);
      },
    },
    bodyValue: {
      get() {
        return this.body;
      },
      set(value) {
        this.$emit("update:body", value);
      },
    },
  },
  created() {
    
  
  },
};
</script>

<style>
</style>