<template>
  <transition
    enter-active-class="transition duration-200 ease-out"
    enter-from-class="translate-y-1 bottom-0"
    enter-to-class="translate-y-0 bottom-5"
    leave-active-class="transition duration-150 ease-in"
    leave-from-class="translate-y-0 opacity-100"
    leave-to-class="translate-y-1 opacity-0"
  >
    <slot></slot>
  </transition>
</template>

<script>
export default {};
</script>

<style></style>
