<template>
  <div class="">
    <FormLabel :label-for="id">
      {{ label }}
    </FormLabel>
    <textarea
      rows="7"
      v-model="payload"
      class="flex min-h-[80px] w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
      :id="id"
      :type="type"
      :placeholder="label"
      :disabled="disabled"
    ></textarea>
  </div>
</template>

<script>
import { computed } from "vue";
import FormLabel from "./FormLabel.vue";
export default {
  props: ["label", "type", "content", "modelValue", "disabled", "id"],
  setup(props, { emit }) {
    const payload = computed({
      get: () => props.modelValue,
      set: (value) => emit("update:modelValue", value),
    });
    return {
      payload,
    };
  },
  components: { FormLabel },
};
</script>

<style></style>
