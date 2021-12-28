<template>
<div :key="loadedKey">
  <div class="text-4xl">LOL {{$route.params.id}}</div>
  <TextInput label="Title" v-model="content.title"/>
  </div>
</template>

<script>
import TextInput from '../../components/admin/TextInput.vue'
export default {
    components: {TextInput},
    data(){
        return {
            content: undefined,
            loadedKey: 0
        }
    },
    async created(){
        await this.getPage()
    },
    methods:{
        async getPage(){
             try{
              const response = await this.callApi("get", `/pages/${this.$route.params.id}`)
              this.content = response.data
              console.log(this.content)
              this.loadedKey++;
          }catch(e){
              console.log(e)

          }
        }
    }

}
</script>

<style>

</style>