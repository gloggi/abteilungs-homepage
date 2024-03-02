<template>
  <div class="flex flex-col">
    <FormLabel v-if="label">{{ label }}</FormLabel>
    <div class="h-9 flex items-center">
      <label class="relative inline-flex items-center cursor-pointer">
        <input
          type="checkbox"
          v-model="checkboxValue"
          class="sr-only peer"
          checked
        />
        <div
          class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900"
        ></div>
      </label>
    </div>
  </div>
</template>
<script>
import FormLabel from "./FormLabel.vue";

export default {
  props: ["modelValue", "label"],
  computed: {
    checkboxValue: {
      get() {
        return this.modelValue ? true : false;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
  components: { FormLabel },
};
</script>
