<template>
  <button
    class="rounded-full size-10 flex justify-center items-center transition-colors duration-300 ease-in-out"
    :class="
      reverse
        ? 'bg-gray-400 hover:bg-white text-white hover:text-gray-400'
        : 'bg-white hover:bg-gray-400 text-gray-400 hover:text-white'
    "
  >
    <slot></slot>
  </button>
</template>
<script>
export default {
  components: {},
  props: ["reverse"],
  data() {
    return {};
  },
  methods: {},
};
</script>
