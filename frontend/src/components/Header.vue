<template>
    <div v-if="$route.path==='/'" class="header-large">
        <svg xmlns="http://www.w3.org/2000/svg" style="height:0; width:0; position: fixed;">
            <defs>
                <filter id="shadow">
                    <feDropShadow stdDeviation="4"/>
                </filter>
            </defs>
        </svg>
        <img class="header__image-large" :src="page.banner.data.full_url">
        <div class="header__banner-large">
            <img class="header__logo-large" :src="settings.logo.data.full_url" alt="" style="filter:url(#shadow)"/>
            <h1 class="header__title">{{settings.scout_group_name}}</h1>
        </div>
    </div>
    <div class="header" v-else>
        <svg xmlns="http://www.w3.org/2000/svg" style="height:0; width:0; position: fixed;">
            <defs>
                <filter id="shadow">
                    <feDropShadow stdDeviation="4"/>
                </filter>
            </defs>
        </svg>
        <img class="header__image-large" :src="page.banner.data.full_url">
        <div class="header__banner">
            <img class="header__logo" :src="settings.logo.data.full_url" alt="" style="filter:url(#shadow)"/>
            <h1 class="header__title">{{settings.scout_group_name}}</h1>
        </div>
        <h1 class="header__heading">{{page.name}}</h1>
    </div>
</template>

<script>
export default {
    name: "Header",
    props: ["page", "settings"]
}
</script>

<style scoped>

</style>