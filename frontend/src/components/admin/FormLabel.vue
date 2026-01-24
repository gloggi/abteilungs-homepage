<template>
  <label
    class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 text-gray-950"
    :for="for"
  >
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
