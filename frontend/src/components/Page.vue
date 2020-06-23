<template>
    <div>
        <div class="window">
            <div class="content">
                <template v-for="content in page.contents">
                    <div v-if="content.separator_banner" class="content__big_image_container" :key="'img-'+content.id">
                        <img class="content__big_image" :src="content.separator_banner.data.full_url">
                    </div>
                    <div v-if="content.content" class="content__block" :key="content.id"
                         v-html="content.content">
                    </div>
                    <div v-if="content.whoweare_show" class="content__block" :key="'whoweare-'+content.id">
                        <h2 class="heading-2">Unsere Gruppen</h2>
                        <groups-container
                                :age_levels="age_levels"
                                :groups="groups"></groups-container>
                    </div>
                    <div v-if="content.whoweare_show_contacts" class="content__block" :key="'contacts-'+content.id">
                        <h2 class="heading-2">Kontakt</h2>
                        <contact-container :contacts="contacts"></contact-container>
                    </div>
                    <template v-if="content.whatwedo_show">
                        <what-we-do :age_levels="age_levels" :key="'whatwedo-'+content.id"></what-we-do>
                    </template>
                    <template v-if="content.form_fields">
                        <form-fields :form_title="content.form_title" :form_email="content.form_email" :form_fields="content.form_fields" :key="'form-'+content.id"></form-fields>
                    </template>
                    <template v-if="content.agenda_sections">
                    <agenda :agenda_sections="content.agenda_sections" :groups="groups" :events="events"
                            :special_events="special_events"
                            :locations="locations"
                            :settings="settings" :key="'agenda-'+content.id"></agenda>
                    </template>
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
    import Agenda from "./Agenda";

    export default {
        name: "Page",
        components: {Agenda, FormFields, WhatWeDo, ContactContainer, GroupsContainer},
        props: ["page", "pages", "age_levels", "groups", "contacts","locations", "special_events", "events", "settings"],
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