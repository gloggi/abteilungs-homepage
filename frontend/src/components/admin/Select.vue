<template>
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
  >
  <option :selected="!value">-</option>
    <option :selected="option['id']==value" v-for="option in options" :value="option['id']" :key="option['id']">{{option.name}} </option>
  </select>
</template>

<script>
export default {
  props:["options", "selection", "value"],
  methods:{
    handleChange(event){
      this.$emit(`select${this.selection}`, event.target.value);
    }
  }

}
</script>

<style>

</style>