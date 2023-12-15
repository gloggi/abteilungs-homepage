<template>
    <div class="w-full px-24">
        <h1 class="text-primary text-5xl font-light pb-5 text-header-3">Kontakt</h1>
        <div class="flex flex-col space-y-5">
        <div v-for="contact in contacts" :key="contact.id" class="flex flex-col space-y-3 md:space-y-0 md:flex-row justify-between">
            <div class="flex flex-col main-text">
                <h2 class="header-text-2 text-4xl text-primary pb-3">
                    {{ contact.role }}
                </h2>
                <p>{{ contact.firstname }} {{ contact.lastname }} {{ contact.nickname?'v/o':'' }} {{ contact.nickname }}</p>
                <a class="link hover:text-secondary" :href="`mailto:${contact.email}`">{{ contact.email }}</a>

            </div>
            
            <img :src="this.backendURL+contact.file.path" class="w-36 h-36 object-cover rounded-full" />
           
        </div>
    </div>

        
    </div>
</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            contacts: []
        };
    },
    methods: {
        async getContacts(){
            try{
                const response = await this.callApi('get', '/contacts');
                this.contacts = response.data.data;
            }catch(e){
                console.log(e)
            }
        }
    },
    async created() {
        await this.getContacts()
    },
    components: {}
}
</script>