<template>
  <DragItemBox :boxTitle="boxTitle" :item="item" @delete="event=>$emit('delete', event)" @startedDragging="$emit('startedDragging')" @endedDragging="$emit('endedDragging')" >
  <Card class="p-0 space-y-2">
    <div class="">
    <TextInput  label="Title" v-model.lazy="titleValue" />
    <Editor class="mt-2" v-model.lazy="bodyValue" />
  </div>
  </Card>
</DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import DragItemBox from "../DragItemBox.vue";
import Editor from "../Editor/Editor.vue";
import TextInput from "../TextInput.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
export default {
  components: { TextInput, Editor, Card, DragItemBox },
  props: [ "title", "body", "item", "boxTitle" ],
  emits: ["updatePage", "update:title", "update:body", "delete", "startedDragging", "endedDragging"],
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
    }
    
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