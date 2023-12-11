<template>
<div class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2" :key="listKey">
        <div v-for="file in content" :key="file.id" 
        :class="`bg-gray-200 rounded-lg h-full ${isItemIncluded(file)?'ring-4 ring-offset-2 ring-blue-400': ''}`" 
        @click="selectItem(file)">
           
                
                <img :src="`${backendURL}${file.thumbnail}`" class="w-full rounded-t-lg object-cover aspect-square" />
           
        </div>
    </div>
</template>
<script>
export default {
    props: {
        category: {
            type: String,
            default: "general"
        },
        maxSelect:{
            type: Number,
            default: 1
        },
        preSelected:{
            type: Array,
        }
    },
    emits: ["selectItems"],
    data() {
        return {
            content: undefined,
            listKey: 0,
            items: []
        };
    },
    methods: {
        isItemIncluded(item){
            return this.items.find(i => i.id == item.id)
        },
        async getMedia() {
            try {
                const response = await this.callApi("get", "/files");
                this.content = response.data.data;
                this.listKey++;
            } catch (e) {
                console.log(e);
            }
        },
        selectItem(item){
            if(this.items.includes(item)){
                this.items = this.items.filter(i => i !== item);
                this.$emit("selectItems", [...this.items])
                return
            }else if(this.items.length==this.maxSelect){
                this.items.shift()
                this.items.push(item)
            }else{
                this.items.push(item)
            }
           this.$emit("selectItems", this.items)
            

        }
    },
    async created() {
        await this.getMedia();
        this.items = this.preSelected || []
        this.listKey++;
    },
}
</script>