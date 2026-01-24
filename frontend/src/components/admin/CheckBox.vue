<template>
  <div class="flex flex-col">
    <FormLabel v-if="label" :for="id">{{ label }}</FormLabel>
    <div class="h-9 flex items-center">
      <label class="relative inline-flex items-center cursor-pointer">
        <input
          :id="id"
          type="checkbox"
          v-model="checkboxValue"
          class="sr-only peer"
          checked
        />
        <div
          class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 focus-visible:ring-offset-white disabled:cursor-not-allowed disabled:opacity-50 bg-gray-200 peer-checked:bg-gray-900"
        ></div>
        <div
            class="pointer-events-none absolute block h-5 w-5 rounded-full bg-white shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0 peer-checked:translate-x-5 translate-x-0 ml-0.5"
        ></div>
      </label>
    </div>
  </div>
</template>
<script>
import FormLabel from "./FormLabel.vue";

export default {
  props: ["modelValue", "label", "id"],
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
