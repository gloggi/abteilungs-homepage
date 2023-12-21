<template>
    <div v-for="section in sections" :key="section.id" class="space-y-5">
        <ImageItem v-if="false" :item="section" />
        <div class="w-full px-24">
        <HeadingOne class="text-primary">{{ section.name }}</HeadingOne>
        <div v-if="section.file" class="float-right rounded-full w-[200px] h-[200px] flex justify-center items-center" :style="`background-color: ${section.color}`">
           <img :src="this.backendURL+section.file?.path" class="w-[60%] h-[60%]">
        </div>
        <div v-html="section.description" v-router-link></div>

    </div>
    </div>
</template>
<script>
import HeadingOne from "./HeadingOne.vue";
import ImageItem from "./ImageItem.vue";


export default {
    props: ["item"],
    data() {
        return {
            sections: []
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
        }
    },
    async created() {
        await this.getSections();
    },
    components: { ImageItem, HeadingOne }
}
</script>