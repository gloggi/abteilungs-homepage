<template>
  <Card v-if="textItem" class="relative">
    <div class="absolute right-0 top-0">
          <button @click="deleteItem" class="border-l p-1 border-b border-gray-200 rounded-bl-lg">
            <TrashIcon class="h-6 w-6 text-gray-500" />
            </button>
      </div>
    <TextInput label="Title" v-model="textItem.title" />
    <Editor class="mt-2" v-model="textItem.text" />
  </Card>
</template>

<script>
import Card from "../Card.vue";
import Editor from "../Editor/Editor.vue";
import TextInput from "../TextInput.vue";
import {
  TrashIcon
} from "@heroicons/vue/solid";
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
    async update() {
      try {
        await this.callApi("put", `${this.textItem["@id"]}`, this.textItem);
      } catch (e) {
        console.log(e);
      }
    },
    async deleteItem() {
      try {
        await this.callApi("delete", `${this.textItem["@id"]}`);
        this.$emit("updatePage")
      } catch (e) {
        console.log(e);
      }
    },
  },
  mounted() {
    this.textItem = {...this.item}
  },
};
</script>

<style>
</style>