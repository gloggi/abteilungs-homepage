<template>
<Fade>
  <div
  v-if="$store.state.modal.open"
    class="
      absolute
      z-50
      top-1/2
      left-1/2
      transform
      -translate-x-1/2 -translate-y-1/2
      bg-white
      border-gray-100
      w-2/3
      h-2/3
      shadow-lg
      rounded-lg
    "
  >
  <button @click="$store.commit('modal/closeModal')" class="absolute z-100 p-1 right-0 border-l border-b border-gray-200 rounded-bl-lg text-gray-400"><XIcon/></button>

   <div class="text-4xl font-bold rounded-t-lg bg-gray-50 p-3">
       Titel
   </div>
   <hr>
   <div class="p-5">
       afnaksdnfkjandfkjnakjfdsnkjadsnkjfa
   </div>

    
  </div>
</Fade>
</template>

<script>
import XIcon from '../../icons/XIcon.vue';
import Fade from '../../transitions/Fade.vue';

export default {
  components: { XIcon, Fade },
};
</script>

<style></style>
