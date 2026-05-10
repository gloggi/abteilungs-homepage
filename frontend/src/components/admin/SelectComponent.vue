<template>
  <div class="w-full">
    <FormLabel :label-for="id">
      {{ label }}
    </FormLabel>
    <select
      :id="id"
      :value="modelValue"
      @change="(event) => handleChange(event)"
      class="flex h-10 w-full items-center justify-between rounded-md border border-gray-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus:outline-hidden focus:ring-2 focus:ring-gray-950 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1"
      :class="`${errors ? ' border-red-500' : ''}`"
    >
      <option
        v-if="!required"
        :selected="modelValue === null || modelValue === undefined"
        value=""
      >
        -
      </option>
      <option
        :selected="option['id'] == modelValue"
        v-for="option in options"
        :value="option['id']"
        :key="option['id']"
      >
        {{ option.name }}
      </option>
    </select>
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
  props: {
    options: null,
    modelValue: null,
    label: null,
    errors: null,
    info: null,
    id: null,
    returnInt: {
      type: Boolean,
      default: true,
    },
    required: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["update:modelValue"],
  methods: {
    handleChange(event) {
      if (event.target.value === "") {
        this.$emit("update:modelValue", null);
        return;
      }
      if (this.returnInt) {
        this.$emit("update:modelValue", parseInt(event.target.value));
      } else {
        this.$emit("update:modelValue", event.target.value);
      }
    },
  },
  components: { FormLabel, InfoField },
};
</script>

<style></style>
