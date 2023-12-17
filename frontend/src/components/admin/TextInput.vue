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
      :class="`${errors? ' border-red-400':''}`"
      :id="label"
      :type="type"
      :readonly="readonly"
      :placeholder="placeholder||label"
      :disabled="disabled"
      @keyup="e=>$emit('keyup',e)"
    />
   <div v-if="errors" class="text-red-400 text-xs">
    {{ errors.join(" ") }}
  </div>
  </div>
</template>

<script>
import FormLabel from './FormLabel.vue';

export default {
    props: ["label", "type", "modelValue", "disabled", "placeholder", "readonly", "errors"],
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