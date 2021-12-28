<template>
      
      <div class="flex flex-no-wrap bg-gray-200">
                    <Sidebar/>
                    <div class="container mx-auto py-10 h-64 md:w-4/5 w-11/12 px-6 ">
                        <div class="w-full h-full">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>

</template>

<script>
import Sidebar from '../components/admin/Sidebar.vue'
export default {
  components: { Sidebar },
    computed:{
        user(){
            return this.$store.state.user.user.username
        }
    }

}
</script>

<style>

</style>