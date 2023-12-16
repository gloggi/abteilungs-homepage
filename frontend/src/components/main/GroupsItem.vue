<template>
    <div class="space-y-5 px-24">
        <div class="w-full">
            <div v-for="section in sections" class="flex" :key="section.id" :style="`background-color: ${section.color}`">
                <div class="flex flex-col p-3 justify-between items-center space-y-12 ">
                    <img v-if="section.file" :src="this.backendURL+section.file?.path" class="w-[100px] h-[100px]">
                    <div v-else class="w-[100px] h-[100px]"></div>
                    <div>
                        <h3 class="text-3xl text-heading-3 text-primary">
                            {{ section.name }}
                        </h3>
                        <p class="main-text text-lg text-white">{{ section.fromAge }} - {{ section.toAge }} Jahre</p>
                    </div>
                </div>
                <div class="flex justify-around w-full items-center">
                    <template v-for="group in groups" :key="group.id">
                    <div v-if="group.section.id===section.id" class="relative rounded-full aspect-square w-[150px] flex justify-center items-center" :style="`background-color: ${group.color}`">
                        <div class="absolute top-0 right-0 rounded-full w-10 h-10 bg-secondary flex justify-center items-center">
                            <img :src="selectGenderIcon(group.gender)" class="w-[65%] h-[65%]">
                        </div>
                        <img :src="this.backendURL+group.file?.path" class="w-[60%] h-[60%]">
                    </div>
                    </template>
                </div>
            
            </div>
        </div>

        
    </div>
</template>
<script>
import bIcon from '@/assets/b.svg';
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
        },
        selectGenderIcon(gender){
           if(gender===1){
            return this.getAsset('b.svg');
           }else if(gender===2){
            return this.getAsset('m.svg')
           }else if(gender===3){
            return this.getAsset('f.svg')
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