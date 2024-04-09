<template>
  <div class="relative">
    <input
      id="pickColor"
      class="opacity-0 absolute h-8 w-8"
      v-model="value"
      type="color"
    />
    <font-awesome-icon
      class="h-5 w-5"
      :icon="icons.faFont"
      :style="{ color: value }"
    />
    <label for="pickColor" class="select-none"></label>
  </div>
</template>

<script>
import { faFont } from "@fortawesome/free-solid-svg-icons";

export default {
  props: ["modelValue"],
  data() {
    return {
      icons: {
        faFont,
      },
    };
  },

  computed: {
    value: {
      get() {
        return this.modelValue;
      },
      set(v) {
        this.$emit("update:modelValue", v);
      },
    },
  },
};
</script>

<style></style>
