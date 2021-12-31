<template>
    <DragAndDropUpload @uploadedFile="getMedia" />
    <div class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2" :key="listKey">
        <a v-for="file in content" target="_blank" :key="file['@id']" :href="file.contentUrl">
            <div class="bg-gray-50 rounded-lg">
                <img v-if="file.type.split('/')[0]=='image'" :src="file.contentUrl" class="w-full rounded-t-lg" />
               <div class="px-5 pb-5 pt-2 break-words">{{ file.contentUrl.substr(21) }}</div>
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
                const response = await this.callApi("get", "/media_objects");
                console.log(response);
                this.content = response.data["hydra:member"];
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
