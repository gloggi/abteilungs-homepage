<template>
  <div
    class="rounded-full border border-gray-200 shadow-sm relative overflow-hidden transition-all duration-300"
    :style="{ backgroundColor }"
  >
    <div class="flex h-full w-full items-center justify-center">
      <img
        v-if="src"
        :src="src"
        class="transition-transform duration-300 hover:scale-105"
        :class="cover ? 'h-full w-full object-cover' : 'object-contain'"
        :style="!cover ? { height: `${size}%`, width: `${size}%` } : {}"
        alt="Logo"
      />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    src: {
      type: String,
      default: "",
    },
    size: {
      type: Number,
      default: 100,
    },
    backgroundColor: {
      type: String,
      default: "#e5e7eb",
    },
    cover: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
