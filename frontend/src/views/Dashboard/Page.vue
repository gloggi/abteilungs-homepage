<template>
    <div :key="loadedKey" v-if="content">
        <Card
            class="flex justify-between items-center mb-2"
        >
            <h2 class="font-extrabold text-4xl">{{ content.title }}</h2>
            <div>
                <button
                    class="rounded-lg bg-green-500 text-white p-2"
                    @click="updateAll"
                >
                    <PlusIcon />
                </button>
            </div>
        </Card>
        <Card>
            <TextInput label="Title" v-model="content.title" />
            <TextInput class="mt-2" label="Route" v-model="content.route" />
        </Card>
        <div v-for="(pageItem) in content.pageItems" :key="pageItem.sort">
            <AddPageItem :position="pageItem.sort" @addComponent="handleAddComponent" />
            <Fade>
            <Card>
                <TextInput label="Title" v-model="pageItem.title" />
                <Editor class="mt-2" v-model="pageItem.text" />
                <hr/>
                <div class="flex justify-end p-2">
                    <button
                    class="rounded-lg bg-red-500 text-white text-sm p-1"
                    @click="()=>{deleteItem(pageItem['@id'])}"
                >
                    Delete
                </button>
                </div>
            </Card>
            </Fade>
        </div>
        <AddPageItem :position="lastPageItemPosition" @addComponent="handleAddComponent" />
    </div>
</template>

<script>
//import Textarea from "../../components/admin/Textarea.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Card from "../../components/admin/Card.vue";
import PlusIcon from "../../icons/PlusIcon.vue"
import AddPageItem from '../../components/admin/AddPageItem.vue';
import Editor from '../../components/admin/Editor/Editor.vue';
import Fade from '../../transitions/Fade.vue';
export default {
    components: { TextInput, Card, PlusIcon, AddPageItem, Editor, Fade },
    data() {
        return {
            content: undefined,
            loadedKey: 0,
        };
    },
    async created() {
        await this.getPage();
    },
    computed:{
        lastPageItemPosition(){
            if(this.content.pageItems.length>0){
                return this.content.pageItems[this.content.pageItems.length-1].sort+1
            }
            return 0
        }
    },
    methods: {
        async handleAddComponent(event){
            console.log(event)
            let pItems = this.content.pageItems;
            for(let i=0; i<pItems.length;i++){
                if(pItems[i].sort>=event.position){
                    pItems[i].sort = pItems[i].sort+1
                }
            }
            await this.createNewItem(this.content["@id"],event.type, event.position);
            await this.updateAll();
            await this.getPage();
            
        },
        async createNewItem(page, itemType, sort){
            try {
                await this.callApi(
                    "post",
                    `/${itemType}`,
                    {sort, page}
                );
            } catch (e) {
                console.log(e);
            }
        },
        async getPage() {
            try {
                const response = await this.callApi(
                    "get",
                    `/pages/${this.$route.params.id}`
                );
                this.content = response.data;
                console.log(this.content);
                this.loadedKey++;
            } catch (e) {
                console.log(e);
            }
        },
        async updateAll() {
            this.content.pageItems.forEach(async (item) => {
                await this.callApi("put", `${item["@id"]}`, item);
            });
            const page = { ...this.content };
            delete page["pageItems"];
            try {
                const response = await this.callApi(
                    "put",
                    `/pages/${this.$route.params.id}`,
                    page
                );
                this.content = response.data;
                console.log(this.content);
                this.loadedKey++;
            } catch (e) {
                console.log(e);
            }
        },
        async deleteItem(iri){
            try {
                await this.callApi(
                    "delete",
                    iri
                );
                this.getPage();
            } catch (e) {
                console.log(e);
            }

        }
    },
};
</script>

<style></style>
