<template>
  <div class="relative">
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
        class="absolute z-10 inset-x-0 -top-10 h-full flex flex-col items-center justify-end"
      >
        <div
          class="p-1 bg-gray-400 rounded-lg text-white text-xs text-center min-w-full"
        >
          {{ toolTipText }}
        </div>
        <div
          class="h-0 w-0 border-x-8 border-x-transparent border-t-8 border-t-gray-400"
        ></div>
      </div>
    </Transition>
    <button
      class="rounded-full size-10 flex justify-center items-center transition-colors duration-300 ease-in-out"
      @mouseover.self="showTooltip"
      @mouseleave.self="hideTooltip"
      :class="
        reverse
          ? 'bg-gray-400 hover:bg-white text-white hover:text-gray-400'
          : 'bg-white hover:bg-gray-400 text-gray-400 hover:text-white'
      "
    >
      <slot></slot>
    </button>
  </div>
</template>
<script>
export default {
  components: {},
  props: {
    reverse: {
      type: Boolean,
      default: false,
    },
    toolTipText: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      showTT: false,
      timeout: undefined,
    };
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
