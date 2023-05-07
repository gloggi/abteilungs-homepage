<template>
<div class="bg-black opacity-50 top-0 w-screen h-screen left-0 fixed z-10">
    </div>
<Fade>
  <div class="
  fixed
      z-20
      inset-0
      flex
      justify-center
      items-center
      ">
  <div
    class="
      bg-white
      border-gray-100
      shadow-lg
      rounded-lg
      w-full
      m-48
      min-h-[75%]
     h-full
    "
  >

   <div class="text-4xl font-bold rounded-t-lg px-5 pt-5 flex justify-between">
       <div>{{title}}</div>
       <button @click="handleClose" class="rounded-bl-lg text-gray-400"><XMarkIcon class="h-6 w-6 text-gray-400"/></button>
   </div>
   
 
   <div class="px-5 overflow-y-auto h-full">
      <slot ></slot>
   </div>
   
  </div>
 
 
  
</div>
</Fade>
</template>

<script>
import Fade from '../../transitions/Fade.vue';
import { XMarkIcon } from '@heroicons/vue/24/solid'

export default {
  components: { XMarkIcon, Fade },
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
