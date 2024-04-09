<template>
  <button
    :class="`${
      active ? 'bg-gray-100 ' : 'bg-white'
    } hover:bg-gray-100  border-y border-r border-gray-700 p-1 text-sm text-gray-700 aspect-square`"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: ["active"],
};
</script>

<style></style>
