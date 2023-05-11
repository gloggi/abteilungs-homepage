<template>
  <div class="">
    <label class="block text-gray-700 text-sm font-bold mb-1" for="username">
      {{ label }}
    </label>
    <textarea
    rows="7"
      v-model="payload"
      class="
        appearance-none
        border
        rounded
        w-full
        py-2
        px-3
        text-gray-700
        leading-tight
        focus:outline-none focus:shadow-outline
      "
      :id="label"
      :type="type"
      :placeholder="label"
      :disabled="disabled"
    ></textarea>
  </div>
</template>

<script>
import { computed } from "vue";
export default {
  props: ["label", "type", "content", "modelValue", "disabled"],
  setup(props, { emit }) {
    const payload = computed({
      get: () => props.modelValue,
      set: (value) => emit("update:modelValue", value),
    });

    return {
      payload,
    };
  },
};
</script>

<style>
</style>