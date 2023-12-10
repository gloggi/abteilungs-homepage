<template>
  <div class="">
   <FormLabel>
      {{ label }}
    </FormLabel>
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
      :readonly="readonly"
      :placeholder="placeholder||label"
      :disabled="disabled"
      @keyup="e=>$emit('keyup',e)"
    />
  </div>
</template>

<script>
import FormLabel from './FormLabel.vue';

export default {
    props: ["label", "type", "modelValue", "disabled", "placeholder", "readonly"],
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
    components: { FormLabel }
};
</script>

<style>
</style>