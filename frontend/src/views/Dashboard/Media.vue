<template>
    <DragAndDropUpload @uploadedFile="getMedia" />
    <div class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2" :key="listKey">
        <a v-for="file in content" target="_blank" :key="file.id" :href="`http://localhost:8000${file.path}`">
            <div class="bg-gray-50 rounded-lg h-full">
                <img :src="`http://localhost:8000${file.thumbnail}`" class="w-full rounded-t-lg object-cover aspect-square" />
               <div class="px-5 pb-5 pt-2 break-words">{{ file.path }}</div>
            </div>
        </a>
    </div>
</template>

<script>
import DragAndDropUpload from "../../components/admin/DragAndDropUpload.vue";

export default {
    components: { DragAndDropUpload },
    data() {
        return {
            content: undefined,
            listKey: 0
        };
    },
    methods: {
        async getMedia() {
            try {
                const response = await this.callApi("get", "/files");
                console.log(response);
                this.content = response.data.data;
                this.listKey++;
            } catch (e) {
                console.log(e);
            }
        },
    },
    async created() {
        await this.getMedia();
    },
};
</script>

<style></style>
