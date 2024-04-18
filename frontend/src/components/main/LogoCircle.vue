<template>
  <div
    class="relative cursor-pointer rounded-full aspect-square w-[200px] flex justify-center items-center float-right bg-primary"
    :style="`background-color: ${logoCircle.color}`"
  >
    <img :src="`${backendURL}${logoCircle.path}`" class="w-[60%] h-[60%]" />
  </div>
</template>
<script>
import fleurDeLis from "../../assets/fleur-de-lis.svg?url";
export default {
  props: ["logoCircle"],
  data() {
    return {
      fleurDeLis,
    };
  },
  methods: {},
  async created() {},
};
</script>
