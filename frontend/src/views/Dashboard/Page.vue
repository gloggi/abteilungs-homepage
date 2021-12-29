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
        <div v-for="(pageItem, i) in content.pageItems" :key="i">
            <AddPageItem :position="pageItem.sort" @addComponent="handleAddComponent" />
            <Card>
                <TextInput label="Title" v-model="pageItem.title" />
                <Textarea class="mt-2" label="Text" v-model="pageItem.text" />
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
        </div>
    </div>
</template>

<script>
import Textarea from "../../components/admin/Textarea.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Card from "../../components/admin/Card.vue";
import PlusIcon from "../../icons/PlusIcon.vue"
import AddPageItem from '../../components/admin/AddPageItem.vue';
export default {
    components: { TextInput, Textarea, Card, PlusIcon, AddPageItem },
    data() {
        return {
            content: undefined,
            loadedKey: 0,
        };
    },
    async created() {
        await this.getPage();
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
