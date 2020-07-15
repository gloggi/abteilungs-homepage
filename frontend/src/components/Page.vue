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
                                :age-levels="ageLevels"
                                :groups="groups"
                                :settings="settings"
                                :events="events"></groups-container>
                    </div>
                    <div v-if="content.whoweare_show_contacts" class="content__block" :key="'contacts-'+content.id">
                        <h2 class="heading-2">Kontakt</h2>
                        <contact-container :contacts="contacts"></contact-container>
                    </div>
                    <what-we-do v-if="content.whatwedo_show"
                                :age-levels="ageLevels"
                                :key="'whatwedo-'+content.id"></what-we-do>
                    <form-fields v-if="content.form_fields"
                                 :form-title="content.form_title"
                                 :form-fields="content.form_fields"
                                 :key="'form-'+content.id"></form-fields>
                    <agenda v-if="content.agenda_sections"
                            :agenda-sections="content.agenda_sections"
                            :groups="groups"
                            :events="events"
                            :special-events="specialEvents"
                            :locations="locations"
                            :settings="settings"
                            :key="'agenda-'+content.id"></agenda>
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
    props: ["page", "ageLevels", "groups", "contacts", "locations", "specialEvents", "events", "settings"],
}
</script>

<style scoped>

</style>