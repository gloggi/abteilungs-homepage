<template>
  <div class="justify-center flex flex-col bg-yellow-300 items-center h-screen">
    <div class="text-4xl">
      Main frontend comming 🔜
    </div>
    <router-link to="/login">
    <button class="bg-blue-600 hover:bg-blue-500 rounded-lg p-2 mt-3 text-white">
      To Login Page
    </button>
    </router-link>
  </div>
</template>
<script>
export default {
  name: 'App',
};
</script>