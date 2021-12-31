<template>
  <div class="justify-center flex flex-col bg-gray-900 items-center h-screen">
      <div class="w-1/2 md:w-1/4">
      <form @submit.prevent="login">
    <div class="bg-white rounded-lg p-4 shadow-lg flex space-y-4 flex-col">
     <div class="text-4xl font-bold">
         Login
     </div>
     <ErrorMessage />
     <hr>
     
         <TextInput v-model="form.username" label="Username" type="text" :content="form.username"></TextInput>
        <TextInput v-model="form.password" label="Password" type="password" :content="form.username"></TextInput>
     <Button type="submit">Login</Button>
    </div>
    </form>
    </div>
  </div>
</template>
<script>
import TextInput from '../components/admin/TextInput.vue';
import Button from '../components/admin/Button.vue';
import ErrorMessage from '../components/admin/ErrorMessage.vue';
export default {
  name: 'Login',
  components: {TextInput, Button, ErrorMessage},
  data(){
      return {
          form:{
              username: undefined,
              password: undefined
          }
      }
  },
  computed:{
      
  },
  methods:{
      printCredentials(){
          console.log(this.form)
      },
      async login(){
          try{
          const response = await this.callApi("post", "/login", this.form)
          console.log(response.headers.location)
          await this.$store.dispatch("user/storeUser",response.headers.location)
          this.$router.push("/dashboard")
          }catch(e){
              console.log(e)
             console.log("Error occured")
          }
      }
  }
};
</script>