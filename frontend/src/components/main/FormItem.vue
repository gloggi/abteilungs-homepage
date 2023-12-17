<template>
    <form class="px-24 space-y-5" @submit.prevent="handleForm">
        <h1 class="text-primary text-4xl text-heading-3">{{ item.form.name }}</h1>
   
    <div class="flex flex-col  space-y-5 pl-4">
        <div v-for="field in item.form.fields" class="flex flex-col space-y-2">
            <label class="font-bold main-text text-2xl" for="form.label">{{ field.label }} {{ field.required?'*':'' }}</label>
            <input v-if="field.type=='textField'" v-model="formContent[field.key]" :required="field.required" class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary" :type="field.inputType" :placeholder="field.placeholder" />
            <textarea v-if="field.type=='textareaField'" v-model="formContent[field.key]" :required="field.required" rows="3" class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary" :placeholder="field.placeholder"></textarea>
            <select v-if="field.type=='selectField'" v-model="formContent[field.key]" :required="field.required" class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary">
                <option v-for="option in field.optionFields" :key="option.id" :value="option.name">{{ option.name }}</option>
            </select>
        </div>
        
    </div>
    <button type="submit" class="bg-primary text-white rounded-lg p-5 hover:bg-secondary w-fit main-text">Absenden</button>
    </form>
</template>
<script>
export default {
    props: ['item'],
    data() {
        return {
            formContent:{}
        }
    },
    methods:{
        async handleForm(){
            try {
                this.formContent.id = this.item.form.id;
                const response = await this.callApi('post', '/webforms', this.formContent)
                console.log(response)
            }catch (error) {
                console.log(error)
            }
            
        }
        
    },
    async created() {
      
    },
}
</script>