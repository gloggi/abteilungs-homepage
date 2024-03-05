<template>
  <div
    class="relative cursor-pointer rounded-full aspect-square w-[200px] flex justify-center items-center bg-primary float-right"
  >
    <img :src="fleurDeLis" class="w-[60%] h-[60%]" />
  </div>
</template>
<script>
import fleurDeLis from "../../assets/fleur-de-lis.svg?url";
export default {
  props: [],
  data() {
    return {
      fleurDeLis,
    };
  },
  methods: {},
  async created() {},
};
</script>
