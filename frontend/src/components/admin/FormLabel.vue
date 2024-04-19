<template>
  <label class="block text-gray-700 text-sm font-bold mb-1" :for="for">
    <slot></slot>
  </label>
</template>
<script>
export default {
  components: {},
  props: {
    for: {
      type: String,
      default: "",
    },
  },
  data() {
    return {};
  },
};
</script>
