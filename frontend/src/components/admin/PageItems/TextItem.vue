<template>
  <DragItemBox :boxTitle="boxTitle" :item="item" @delete="event=>$emit('delete', event)" @startedDragging="$emit('startedDragging')" @endedDragging="$emit('endedDragging')" >
  <Card class="space-y-2">
    <div class="">
      <div class="flex flex-col md:flex-row space-x-2">
    <TextInput class="w-full"  label="Title" v-model.lazy="titleValue" />
    <div class="w-full md:w-1/4  ">
      <FormLabel class=" ">Show Fleur-de-Lis</FormLabel>
      <CheckBox v-model="fleurDeLis" />
    </div>
  </div>
    <Editor class="mt-2" v-model.lazy="bodyValue" />
  </div>
  </Card>
</DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import CheckBox from "../CheckBox.vue";
import DragItemBox from "../DragItemBox.vue";
import Editor from "../Editor/Editor.vue";
import FormLabel from "../FormLabel.vue";
import TextInput from "../TextInput.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
export default {
  components: { TextInput, Editor, Card, DragItemBox, FormLabel, CheckBox },
  props: [ "title", "body", "item", "boxTitle", "fleurDeLis" ],
  emits: ["updatePage", "update:title", "update:body","update:fleurDeLis", "delete", "startedDragging", "endedDragging"],
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
    fleurDeLis: {
      get() {
        return this.fleurDeLis;
      },
      set(value) {
        this.$emit("update:fleurDeLis", value);
      },
    },
  },
  created() {
    
  
  },
};
</script>

<style>
</style>