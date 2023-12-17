<template>
  <div class="w-full">
   <FormLabel>
      {{ label }}
    </FormLabel>
  <select
  @change="(event)=>handleChange(event)"
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
  >
  <option :selected="!value">-</option>
    <option :selected="option['id']==value" v-for="option in options" :value="option['id']" :key="option['id']">{{option.name}} </option>
  </select>
  <div v-if="errors" class="text-red-400 text-xs">
    {{ errors.join(" ") }}
  </div>
</div>
</template>

<script>
import FormLabel from './FormLabel.vue';

export default {
    props: ["options", "selection", "value", "label", "errors"],
    methods: {
        handleChange(event) {
            this.$emit(`select${this.selection}`, parseInt(event.target.value));
        }
    },
    components: { FormLabel }
}
</script>

<style>

</style>