<template>
<div class="relative">
  <input id="pickColor" class="opacity-0 absolute h-8 w-8" v-model="value" type="color" />
  <div class="rounded-full ring-1 ring-gray-500 border-2 border-white w-8 h-8" :style="`background-color: ${value}`"></div>
  <label for="pickColor" class="select-none"></label>
  </div>
</template>

<script>
import { useModelWrapper } from '../../utils/modelWrapper'

export default { 
  props: { 
    modelValue: String
  },
  setup(props, { emit }) { 
    return { 
      value: useModelWrapper(props, emit, 'modelValue') 
    }
  }
}
</script>

<style>

</style>