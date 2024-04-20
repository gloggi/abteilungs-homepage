<template>
  <div class="my-2 flex relative">
    <div class="absolute left-0 z-10 inset-y-0 flex h-full items-center">
      <font-awesome-icon
        :icon="icons.faMagnifyingGlass"
        class="h-5 w-5 p-2 text-gray-400"
      />
    </div>
    <label class="hidden" for="searchfield"></label>
    <input
      id="searchfield"
      class="appearance-none border-0 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-gray-400 focus:border-gray-400 pl-10"
      v-model="payload"
    />
  </div>
</template>
<script>
import { faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
export default {
  props: {
    modelValue: {
      type: String,
    },
  },
  emits: ["update:modelValue"],
  data() {
    return {
      icons: {
        faMagnifyingGlass,
      },
    };
  },
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
