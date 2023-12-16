<template>
    <div class="space-y-5 px-24">
        <div class="w-full">
            <div v-for="section in sections" class="flex" :key="section.id" :style="`background-color: ${section.color}`">
                <div class="flex flex-col p-3 justify-between items-center space-y-12 ">
                    <img :src="this.backendURL+section.file?.path" class="w-[100px] h-[100px]">
                    <div>
                        <h3 class="text-3xl text-heading-3 text-primary">
                            {{ section.name }}
                        </h3>
                        <p class="main-text text-lg text-white">{{ section.fromAge }} - {{ section.toAge }} Jahre</p>
                    </div>
                </div>
                <div class="flex justify-around w-full items-center">
                    <template v-for="group in groups" :key="group.id">
                    <div v-if="group.section.id===section.id" class="rounded-full aspect-square w-[150px] flex justify-center items-center" :style="`background-color: ${group.color}`">
                        <img :src="this.backendURL+group.file?.path" class="w-[60%] h-[60%]"></div>
                    </template>
                </div>
            
            </div>
        </div>

        
    </div>
</template>
<script>
export default {
    props: ['item'],
    data() {
        return {
            sections: [],
            groups: []
        };
    },
    methods: {
        async getSections(){
            try{
                const response = await this.callApi('get', '/sections');
                this.sections = response.data.data;
            }catch(e){
                console.log(e)
            }
        },
        async getGroups(){
            try{
                const response = await this.callApi('get', '/groups');
                this.groups = response.data.data;
            }catch(e){
                console.log(e)
            }
        }
    },
    async created() {
        await this.getSections();
        await this.getGroups();
    },
    components: { }
}
</script>