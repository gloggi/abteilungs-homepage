<template>
<div class="bg-black opacity-50 top-0 w-screen h-screen left-0 fixed z-10">
    </div>
<Fade>
  <div
    :class="`
      absolute
      z-20
      top-1/2
      left-1/2
      transform
      -translate-x-1/2 -translate-y-1/2
      bg-white
      border-gray-100
      ${expanded?'w-11/12 h-5/6': 'w-2/3 h-2/3'}
      
      shadow-lg
      rounded-lg
    `"
  >
  <div class="absolute z-100 right-0">
    <button @click="handleExpand" class="border-l p-1 border-b border-gray-200 text-gray-400"><ArrowsExpandIcon class="h-6 w-6 text-gray-400"/></button>
    <button @click="handleClose" class="border-l p-1 border-b border-gray-200 rounded-bl-lg text-gray-400"><XIcon class="h-6 w-6 text-gray-400"/></button>
  </div>
  

   <div class="text-4xl font-bold rounded-t-lg bg-gray-50 p-3">
       {{title}}
   </div>
   <hr>
   <div class="relative h-2/3">
      <slot ></slot>
   </div>
   <slot name="footer"></slot>

    
  </div>
</Fade>
</template>

<script>
import Fade from '../../transitions/Fade.vue';
import { XIcon, ArrowsExpandIcon } from '@heroicons/vue/24/solid'

export default {
  components: { XIcon, Fade, ArrowsExpandIcon },
  emits:["close"],
  props: ["title"],
  data(){
    return{
      expanded: false,
      key: 0
    }
  },
  methods:{
    handleClose(){
      this.$emit("close", true)
    },
    handleExpand(){
      this.expanded = !this.expanded;
      this.key++

    }
  }
};
</script>

<style></style>
