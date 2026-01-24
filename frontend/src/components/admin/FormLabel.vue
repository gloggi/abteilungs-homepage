<template>
  <label
    class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 text-gray-950"
    :for="labelFor"
  >
    <slot></slot>
  </label>
</template>
<script>
export default {
  components: {},
  props: {
    labelFor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {};
  },
};
</script>
