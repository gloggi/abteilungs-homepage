<template>
    <div class="w-full px-24">
        <h1 class="text-primary text-5xl pb-2 text-heading-3">{{ item.title }}</h1>
        <div v-html="item.body"></div>

    </div>
</template>
<script>
export default {
    props: ['item'],
    data() {
        return {
            
        }
    },
    methods:{
        
    },
    async created() {
      
    },
}
</script>