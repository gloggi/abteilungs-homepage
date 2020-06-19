<template>
    <div>
        <div class="window">
            <div class="content">
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
    export default {
        name: "Page",
        props: ["page", "pages"],
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