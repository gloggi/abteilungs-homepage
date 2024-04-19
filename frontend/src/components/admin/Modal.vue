<template>
  <div
    class="fixed inset-0 z-30 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full"
  >
    <Fade>
      <div
        class="flex w-full h-full justy-center items-center xl:p-56 lg:p-24 md:p-16 sm:p-4 p-4"
      >
        <div
          class="relative w-full mx-auto p-5 border shadow-lg rounded-lg bg-white max-h-screen"
        >
          <button
            @click="handleClose"
            class="absolute top-2 right-2 rounded-bl-lg text-gray-400"
          >
            <font-awesome-icon
              :icon="icons.faXmark"
              class="h-6 w-6 text-gray-400"
            />
          </button>

          <div class="px-5 h-full">
            <slot></slot>
          </div>
        </div>
      </div>
    </Fade>
  </div>
</template>

<script>
import Fade from "../../transitions/Fade.vue";

import { faXmark } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { Fade },
  emits: ["close"],
  props: ["title"],
  data() {
    return {
      expanded: false,
      key: 0,
      icons: {
        faXmark,
      },
    };
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
    handleExpand() {
      this.expanded = !this.expanded;
      this.key++;
    },
  },
};
</script>

<style></style>
