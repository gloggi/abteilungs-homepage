<template>
    <Card class="space-y-2">
      <Select selection="FormItem" @selectFormItem="handleChange" :value="item.formId" :options="options" />
      
     
    </Card>

  </template>
  
  <script>


  import Card from '../Card.vue';
  import Select from '../Select.vue';

  
  export default {
    components: {  Card, Select },
    props: ["item"],
    emits: ["updatePage", "changeForm"],
    data() {
      return {
        options: []
  
        
      };
    },
    methods: {
      async getForms(){
        try{
          const response = await this.callApi("get", "forms");
          this.options = response.data.data;
          
        }
          catch(error){
            console.log(error);
          }

      },
      handleChange(value){
       this.$emit("changeForm", {formId: value, id: this.item.id});
      }
    },
   
    computed: {
    },
    async created() {
      await this.getForms();
     
  
    },
  

}

  </script>
  
  <style></style>