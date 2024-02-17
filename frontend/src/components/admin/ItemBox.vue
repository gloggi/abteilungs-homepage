<template>
  <div class="border bg-gray-50 rounded-lg p-5 relative h-full">
    <div
      v-if="title"
      class="absolute z-10 top-0 left-0 bg-gray-300 text-white rounded-br-md rounded-tl-md p-1 border-b border-r text-sm font-semibold"
    >
      {{ title }}
    </div>
    <slot></slot>
  </div>
</template>
<script>
export default {
  props: ["title"],
};
</script>
