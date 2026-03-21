<template>
  <button
    :class="[
      'inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50',
      sizeClasses,
      variantClasses,
    ]"
    :disabled="disabled"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    variant: {
      type: String,
      default: "default",
      validator: (value) =>
        [
          "default",
          "destructive",
          "outline-solid",
          "secondary",
          "ghost",
          "link",
        ].includes(value),
    },
    size: {
      type: String,
      default: "default",
      validator: (value) => ["default", "sm", "lg", "icon"].includes(value),
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    variantClasses() {
      const variants = {
        default: "bg-gray-900 text-gray-50 hover:bg-gray-900/90",
        destructive: "bg-red-500 text-gray-50 hover:bg-red-500/90",
        outline:
          "border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-900",
        secondary: "bg-gray-100 text-gray-900 hover:bg-gray-100/80",
        ghost: "hover:bg-gray-100 hover:text-gray-900",
        link: "text-gray-900 underline-offset-4 hover:underline",
      };
      return variants[this.variant];
    },
    sizeClasses() {
      const sizes = {
        default: "h-10 px-4 py-2",
        sm: "h-9 rounded-md px-3",
        lg: "h-11 rounded-md px-8",
        icon: "h-10 w-10",
      };
      return sizes[this.size];
    },
  },
};
</script>

<style></style>
