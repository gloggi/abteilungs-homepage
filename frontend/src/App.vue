<template>
  <router-view/>
</template>
<script>
export default {
  async created(){
    await this.$store.dispatch("user/storeUser",localStorage.user)
   
  }

}
</script>

<style>

</style>