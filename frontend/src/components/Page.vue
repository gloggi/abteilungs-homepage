<template>
    <div>
        <div class="window">
            <div class="content">
                <div v-if="page.whoweare_show" class="content__block">
                    <h2 class="heading-2">Unsere Gruppen</h2>
                    <groups-container
                            :age_levels="age_levels"
                            :groups="groups"></groups-container>
                </div>
                <div v-if="page.whoweare_show_contacts" class="content__block">
                    <h2 class="heading-2">Kontakt</h2>
                    <contact-container :contacts="contacts"></contact-container>
                </div>
                <template v-for="content in page.contents">
                    <div v-if="content.separator_banner" class="content__big_image_container" :key="'img-'+content.id">
                        <img class="content__big_image" :src="content.separator_banner.data.full_url">
                    </div>
                    <div class="content__block" :key="content.id"
                         v-html="content.content">
                    </div>
                </template>
                <template v-if="page.whatwedo_show">
                    <what-we-do :age_levels="age_levels"></what-we-do>
                </template>
                <template v-if="page.form_fields">
                    <form-fields :form_fields="page.form_fields"></form-fields>
                </template>
            </div>

        </div>
    </div>
</template>

<script>
    import GroupsContainer from "./GroupsContainer";
    import ContactContainer from "./ContactContainer";
    import WhatWeDo from "./WhatWeDo";
    import FormFields from "./FormFields";

    export default {
        name: "Page",
        components: {FormFields, WhatWeDo, ContactContainer, GroupsContainer},
        props: ["page", "pages", "age_levels", "groups", "contacts"],
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