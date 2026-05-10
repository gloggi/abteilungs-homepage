<template>
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-xs p-4 transition-all"
    @click.self="handleClose"
  >
    <Fade>
      <div
        class="relative w-full grid gap-4 rounded-xl bg-white p-6 shadow-2xl border border-gray-100 duration-200 sm:rounded-xl"
        :class="maxWidthClass"
      >
        <button
          @click="handleClose"
          class="absolute right-4 top-4 z-10 rounded-xs opacity-70 ring-offset-white transition-opacity hover:opacity-100 focus:outline-hidden focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-gray-100 data-[state=open]:text-gray-500"
        >
          <font-awesome-icon :icon="icons.faXmark" class="h-4 w-4" />
          <span class="sr-only">Close</span>
        </button>

        <div
          v-if="title"
          class="flex flex-col space-y-1.5 text-center sm:text-left"
        >
          <h3
            class="text-lg font-semibold leading-none tracking-tight text-gray-900"
          >
            {{ title }}
          </h3>
        </div>

        <div class="relative overflow-y-auto max-h-[70vh]">
          <slot></slot>
        </div>

        <slot name="footer"></slot>
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
  props: {
    title: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "medium",
    },
  },
  computed: {
    maxWidthClass() {
      switch (this.size) {
        case "sm":
          return "max-w-sm";
        case "lg":
        case "large":
          return "max-w-2xl";
        case "xl":
          return "max-w-4xl";
        case "2xl":
          return "max-w-5xl";
        case "3xl":
          return "max-w-6xl";
        case "4xl":
          return "max-w-7xl";
        case "5xl":
          return "max-w-[1920px]";
        case "full":
          return "max-w-[95vw] h-[90vh]";
        case "medium":
        default:
          return "max-w-lg";
      }
    },
  },
  data() {
    return {
      icons: {
        faXmark,
      },
    };
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
  },
};
</script>
