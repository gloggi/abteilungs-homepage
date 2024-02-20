<template>
  <button
    class="bg-[#622648] hover:bg-[#81516d] rounded-lg p-3 text-white flex items-center justify-center space-x-2"
  >
    <img :src="getAsset('pbs.svg')" class="h-8 w-8" />
    <div>{{ $t("dashboard.viaPbsMiData") }}</div>
  </button>
</template>

<script>
export default {};
</script>

<style></style>
