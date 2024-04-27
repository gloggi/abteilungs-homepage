<template>
  <div class="w-full">
    <FormLabel :for="id">
      {{ label }}
    </FormLabel>
    <input
      v-model="payload"
      class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-gray-900 focus:border-gray-900"
      :class="`${errors ? ' border-red-400' : ''}`"
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
