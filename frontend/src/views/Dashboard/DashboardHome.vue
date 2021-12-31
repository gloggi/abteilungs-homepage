<template>
  <Card class="text-4xl font-extrabold">Hello, {{user.username}}!</Card>
</template>

<script>
import Card from '../../components/admin/Card.vue'
export default {
  components: { Card },
    computed:{
        user(){
            return this.$store.state.user.user
        }
    }

}
</script>

<style>

</style>