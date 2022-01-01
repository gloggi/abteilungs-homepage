<template>
  <div
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
      shadow
      rounded-lg
    "
  >
  <button class="absolute z-100 p-1 right-0 border-l border-b border-gray-200 rounded-bl-lg text-gray-400"><XIcon/></button>
<div class="p-5 mt-5">
    <Media />
</div>
    
  </div>
</template>

<script>
import XIcon from '../../icons/XIcon.vue';
import Media from "../../views/Dashboard/Media.vue";
export default {
  components: { Media, XIcon },
};
</script>

<style></style>
