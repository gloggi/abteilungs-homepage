<template>
    <div>
        <div v-for="age_level in age_levels" :key="age_level.id">
            <div class="content__big_image_container" :key="'img-'+age_level.id">
                <img class="content__big_image" :src="age_level.image.data.full_url">
            </div>
            <div class="content__block" :key="'content-'+age_level.id">
                <h2 class="heading-2">{{age_level.name}}</h2>
                <div class="circle-large" :style="'background-color: '+age_level.color">
                    <img :src="age_level.logo.data.full_url" alt="">
                </div>
                <div class="content__text" v-html="age_level.description"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WhatWeDo",
        props: ["age_levels"]
    }
</script>

<style scoped>

</style>