<template>
  <div class="relative">
    <input
      :id="uid"
      class="opacity-0 absolute h-10 w-10 cursor-pointer"
      v-model="value"
      type="color"
    />
    <div
      class="h-10 w-10 rounded-md border border-gray-200 shadow-sm transition-all peer-focus-visible:ring-2 peer-focus-visible:ring-gray-950 peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-white"
      :class="`${errors ? ' border-red-500' : ''}`"
      :style="`background-color: ${value}`"
    ></div>
    <label :for="uid" class="select-none absolute inset-0 cursor-pointer"></label>
  </div>
  <div v-if="errors" class="text-red-400 text-xs">
    {{ errors.join(" ") }}
  </div>
</template>

<script>
export default {
  props: ["modelValue", "errors", "id"],
  data() {
    return {
      generatedId: `color-picker-${Math.random().toString(36).substr(2, 9)}`,
    };
  },
  computed: {
    uid() {
      return this.id || this.generatedId;
    },
    value: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
};
</script>

<style></style>
