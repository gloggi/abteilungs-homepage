<template >
   <PageWrapper v-if="group">
    <TextItem :item="{title: group.name, body: group.description}" />
       
    </PageWrapper>
</template>
<script>
import PageWrapper from './PageWrapper.vue';
import TextItem from './TextItem.vue';

export default {
    props: ["group"],
    data() {
        return {
           
        };
    },
    methods: {
        
    },
    async created() {
       
    },
    components: { PageWrapper, TextItem }
}
</script>