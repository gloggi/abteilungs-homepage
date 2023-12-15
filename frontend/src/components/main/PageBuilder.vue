<template>
    <div v-if="page" class="flex justify-center w-full background bg-[#808080]">
        <div class="w-full md:w-[900px] bg-white py-12 space-y-12">
            <template v-for="pageItem in page.pageItems" :key="pageItem.id">
                <TextItem v-if="pageItem.type=='textItem'" :item="pageItem" />
                <ImageItem v-if="pageItem.type=='imageItem'" :item="pageItem" />
                <ContactItem v-if="pageItem.type=='contactItem'" :item="pageItem" />
                <FormItem v-if="pageItem.type=='formItem'" :item="pageItem" />
            </template>
        </div>
        
    </div>
</template>
<script>
import ContactItem from './ContactItem.vue';
import FormItem from './FormItem.vue';
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
    components: { TextItem, ImageItem, ContactItem, FormItem }
}
</script>