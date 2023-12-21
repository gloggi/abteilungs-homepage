<template>
    <div class="w-full px-24">
        <FleurDeLis class="hidden md:flex" v-if="item.showFleurDeLis"/>
        <HeadingOne class="text-primary">{{ item.title }}</HeadingOne>
        <div v-html="item.body" v-router-link></div>
        
    </div>
</template>
<script>
import FleurDeLis from './FleurDeLis.vue';
import HeadingOne from './HeadingOne.vue';

export default {
    props: ['item'],
    data() {
        return {};
    },
    methods: {},
    async created() {
    },
    components: { HeadingOne, FleurDeLis }
}
</script>