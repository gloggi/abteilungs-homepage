<template>
    <div>
        <div class="window">
            <div class="content">
                <div v-if="page.whoweare_show" class="content__block">
                    <groups-container
                            :age_levels="age_levels"
                            :groups="groups"></groups-container>
                </div>
                <template v-for="content in page.contents">
                    <div v-if="content.separator_banner" class="content__big_image_container" :key="'img-'+content.id">
                        <img class="content__big_image" :src="content.separator_banner.data.full_url">
                    </div>
                    <div class="content__block" :key="content.id"
                         v-html="content.content">
                    </div>
                </template>
            </div>

        </div>
    </div>
</template>

<script>
    import GroupsContainer from "./GroupsContainer";
    export default {
        name: "Page",
        components: {GroupsContainer},
        props: ["page", "pages", "age_levels", "groups"],
        data() {
            return {}
        },
        methods: {},
        created() {
        }
    }
</script>

<style scoped>

</style>