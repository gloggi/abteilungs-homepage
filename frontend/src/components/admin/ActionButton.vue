<template>
  <div class="relative inline-block">
    <Transition
      enter-active-class="transition ease-out duration-300"
      leave-active-class="transition ease-in duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-if="showTT && toolTipText"
        class="absolute z-50 bottom-full left-1/2 mb-2 -translate-x-1/2 flex flex-col items-center"
      >
        <div
          class="bg-gray-900 text-white text-xs rounded-md px-3 py-1.5 shadow-md whitespace-nowrap animate-in fade-in zoom-in-95 duration-200"
        >
          {{ toolTipText }}
        </div>
        <div
          class="h-0 w-0 border-x-4 border-x-transparent border-t-4 border-t-gray-900"
        ></div>
      </div>
    </Transition>
    <ButtonComponent
      :variant="buttonVariant"
      :size="buttonSize"
      @mouseover="showTooltip"
      @mouseleave="hideTooltip"
      @click="$emit('click')"
    >
      <slot></slot>
    </ButtonComponent>
  </div>
</template>

<script>
import ButtonComponent from "./ButtonComponent.vue";

export default {
  components: {
    ButtonComponent,
  },
  emits: ["click"],
  props: {
    reverse: {
      type: Boolean,
      default: false,
    },
    variant: {
      type: String,
      default: null,
    },
    toolTipText: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "normal",
    },
  },
  data() {
    return {
      showTT: false,
      timeout: undefined,
    };
  },
  computed: {
    buttonVariant() {
      if (this.variant) return this.variant;
      return this.reverse ? "default" : "outline-solid";
    },
    buttonSize() {
      const validSizes = ["default", "sm", "lg", "icon"];
      if (validSizes.includes(this.size)) return this.size;

      switch (this.size) {
        case "small":
          return "sm";
        case "large":
          return "lg";
        case "normal":
        default:
          return "icon";
      }
    },
  },
  methods: {
    showTooltip() {
      if (this.timeout) {
        return;
      }
      this.timeout = setTimeout(() => {
        this.showTT = true;
      }, 500);
    },
    hideTooltip() {
      clearTimeout(this.timeout);
      this.timeout = undefined;
      this.showTT = false;
    },
  },
  beforeUnmount() {
    clearTimeout(this.timeout);
  },
};
</script>
