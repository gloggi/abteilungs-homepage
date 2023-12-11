<template>
      
      <div class="flex flex-no-wrap bg-gray-200 h-full w-full fixed">
                    <Sidebar/>
                    <div class="container mx-auto py-6 h-full md:w-4/5 px-6 overflow-y-scroll">
                        <div class="w-full h-full">
                            <router-view>
                            </router-view>
                        </div>
                    </div>
                </div>
                <SucessMessage />

</template>

<script>
import Sidebar from '../components/admin/Sidebar.vue'
import SucessMessage from '../components/admin/SucessNotification.vue'
export default {
  components: { Sidebar, SucessMessage },
    computed:{
        user(){
            return this.$store.state.user.user
        }
    },
    async created(){
        await this.$store.dispatch('settings/getSettings');
    }

}
</script>

<style>

</style>