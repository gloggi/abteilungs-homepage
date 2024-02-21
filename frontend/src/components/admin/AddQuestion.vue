<template>
  <button
    @click="select"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    :class="`${
      dragging
        ? 'bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500'
        : 'bg-gray-300 hover:bg-gray-400'
    } 
      ${increaseHeight ? 'h-48' : 'h-1.5'}
      rounded-lg my-1 h-1.5 w-full text-xs`"
  ></button>
</template>
<script>
import Modal from "./Modal.vue";

export default {
  data() {
    return {
      increaseHeight: false,
    };
  },
  computed: {
    isDragging() {
      return this.$store.state.drag.dragging;
    },
  },
  components: { Modal },
  props: ["sortKey", "dragging"],
  emits: ["select", "changeOrder"],
  methods: {
    handleDrop(e) {
      this.increaseHeight = false;
      const question = JSON.parse(e.dataTransfer.getData("text"));
      question.sort = this.sortKey + 0.5;
      this.$emit("changeOrder", question);
    },
    select(field) {
      this.$emit("select", {
        question: "",
        answer: "",
        sort: this.sortKey + 0.5,
      });
    },
  },
};
</script>
