<template>
    <div>
        <div v-for="ageLevel in ageLevels" :key="ageLevel.id">
            <div class="content__big_image_container" :key="'img-'+ageLevel.id">
                <img class="content__big_image" :src="ageLevel.image.data.full_url">
            </div>
            <div class="content__block" :key="'content-'+ageLevel.id">
                <h2 class="heading-2">{{ageLevel.name}}</h2>
                <div class="circle-large" :style="'background-color: '+ageLevel.color">
                    <img v-if="ageLevel.logo" :src="ageLevel.logo.data.full_url" alt="">
                </div>
                <div class="content__text" v-html="ageLevel.description"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "WhatWeDo",
    props: ["ageLevels"]
}
</script>

<style scoped>

</style>