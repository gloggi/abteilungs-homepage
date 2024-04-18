<template>
  <div class="rounded-full border" :style="{ backgroundColor }">
    <div
      class="flex justify-center items-center rounded-full overflow-hidden size-full"
    >
      <img
        v-if="src"
        :src="src"
        class="aspect-square"
        :style="{ height: `${size}%`, width: `${size}%` }"
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
  },
};
</script>
