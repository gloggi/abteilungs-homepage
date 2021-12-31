<template>
  <button :class="`rounded-lg ${active?'bg-blue-500':'bg-white'} hover:bg-gray-200 border border-gray-200 p-1 text-sm`">
      <slot></slot>
  </button>
</template>

<script>
export default {
    props: ["active"]

}
</script>

<style>

</style>