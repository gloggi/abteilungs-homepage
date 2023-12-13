<template>
    <div v-if="page" class="flex justify-center w-full background bg-[#808080]">
        <div class="w-full md:w-[900px] bg-white py-12">
            <template v-for="pageItem in page.pageItems" :key="pageItem.id">
                <TextItem v-if="pageItem.type=='textItem'" :item="pageItem" />
                <ImageItem v-if="pageItem.type=='imageItem'" :item="pageItem" />
            </template>
        </div>
        
    </div>
</template>
<script>
import ImageItem from './ImageItem.vue';
import TextItem from './TextItem.vue';

export default {
    props: ['page'],
    data() {
        return {};
    },
    methods: {},
    async created() {
    },
    components: { TextItem, ImageItem }
}
</script>