<template>
  <div class="justify-center flex flex-col bg-yellow-300 items-center h-screen">
      <div class="text-4xl">Dashboard: Welcome {{user}}</div>
  </div>
</template>

<script>
export default {
    computed:{
        user(){
            return this.$store.state.user.user.username
        }
    }

}
</script>

<style>

</style>