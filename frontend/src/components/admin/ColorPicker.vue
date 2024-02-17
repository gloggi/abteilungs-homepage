<template>
  <div class="relative">
    <input
      id="pickColor"
      class="opacity-0 absolute h-8 w-8"
      v-model="value"
      type="color"
    />
    <div
      class="rounded-full ring-1 ring-gray-500 border-2 border-white w-8 h-8"
      :class="`${errors ? ' border-red-400' : ''}`"
      :style="`background-color: ${value}`"
    ></div>
    <label for="pickColor" class="select-none"></label>
  </div>
  <div v-if="errors" class="text-red-400 text-xs">
    {{ errors.join(" ") }}
  </div>
</template>

<script>
import { useModelWrapper } from "../../utils/modelWrapper";

export default {
  props: ["modelValue", "errors"],
  setup(props, { emit }) {
    return {
      value: useModelWrapper(props, emit, "modelValue"),
    };
  },
};
</script>

<style></style>
