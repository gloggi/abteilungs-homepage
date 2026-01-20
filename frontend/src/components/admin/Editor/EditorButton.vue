<template>
  <button
    type="button"
    :class="[
      'inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background h-8 w-8',
      active
        ? 'bg-gray-200 text-gray-900'
        : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900',
    ]"
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

