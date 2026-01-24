<template>
  <button
    @click="select"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    class="rounded-lg my-1 w-full text-xs transition-all duration-200 flex items-center justify-center border border-dashed"
    :class="`${
      dragging
        ? 'bg-gray-100 border-gray-400 text-gray-900 shadow-inner'
        : 'bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-900 border-gray-300 hover:border-gray-400'
    } 
    ${increaseHeight ? 'h-32' : 'h-8 py-2'}`"
  >
    <span v-if="dragging">{{ $t("dashboard.dropPageItemHere") }}</span>
    <span v-else>
      <font-awesome-icon :icon="icons.faPlus" />
      {{ $t("dashboard.clickToAddQuestionItem") }}
    </span>
  </button>
</template>
<script>
import { faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
  data() {
    return {
      increaseHeight: false,
      icons: {
        faPlus,
      },
    };
  },
  computed: {
    isDragging() {
      return this.$store.state.drag.dragging;
    },
  },
  components: {},
  props: ["sortKey", "dragging"],
  emits: ["select", "changeOrder"],
  methods: {
    handleDrop(e) {
      this.increaseHeight = false;
      const question = JSON.parse(e.dataTransfer.getData("text"));
      question.sort = this.sortKey + 0.5;
      this.$emit("changeOrder", question);
    },
    select() {
      this.$emit("select", {
        question: "",
        answer: "",
        sort: this.sortKey + 0.5,
      });
    },
  },
};
</script>
