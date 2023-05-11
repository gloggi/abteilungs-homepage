<template>
  <div class="">
    <label class="block text-gray-700 text-sm font-bold mb-1" for="">
      {{ label }}
    </label>
    <input
      v-model.lazy="payload"
      :lazy="true"
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
    />
  </div>
</template>

<script>
export default {
  props: ["label", "type", "modelValue", "disabled"],
  emits: ["update:modelValue"],
  computed: {
    payload: {
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

<style>
</style>