<template>
  <div
    :dropzone="true"
    @dragenter.prevent=""
    @dragover.prevent
    @drop="handleDrop"
    @dragenter="dragging = true"
    @dragleave="dragging = false"
    :class="`w-full transition-all duration-200 ease-in-out rounded-md ${
      dragging
        ? 'h-12 bg-gray-50 border-2 border-dashed border-gray-300'
        : 'h-1 bg-transparent'
    }`"
  ></div>
</template>
<script>
export default {
  components: {},
  props: ["index"],
  emits: ["droppedItem"],
  data() {
    return {
      dragging: false,
    };
  },
  methods: {
    handleDrop(e) {
      this.dragging = false;
      const item = JSON.parse(e.dataTransfer.getData("text"));
      item.sort = this.index + 0.5;
      this.$emit("droppedItem", item);
    },
  },
};
</script>
