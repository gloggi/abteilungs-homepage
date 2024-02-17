<template>
  <div
    class="bg-red-400 rounded-lg border border-red-700 p-2"
    v-if="$store.state.message.error"
  >
    {{ $store.state.message.error }}
  </div>
</template>

<script>
export default {};
</script>

<style></style>
