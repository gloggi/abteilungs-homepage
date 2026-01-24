<template>
  <div class="w-full">
    <FormLabel :for="id">
      {{ label }}
    </FormLabel>
    <input
      v-model="payload"
      class="flex h-10 w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
      :class="`${errors ? ' border-red-500' : ''}`"
      :id="id"
      :type="type"
      :readonly="readonly"
      :placeholder="placeholder || label"
      :disabled="disabled"
      @keyup="(e) => $emit('keyup', e)"
    />
    <InfoField v-if="info" :info="info" />
    <div v-if="errors" class="text-red-400 text-xs">
      {{ errors.join(" ") }}
    </div>
  </div>
</template>

<script>
import FormLabel from "./FormLabel.vue";
import InfoField from "./InfoField.vue";

export default {
  props: [
    "label",
    "type",
    "modelValue",
    "disabled",
    "placeholder",
    "readonly",
    "errors",
    "info",
    "id",
  ],
  emits: ["update:modelValue", "keyup"],
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
  components: { FormLabel, InfoField },
};
</script>

<style></style>
