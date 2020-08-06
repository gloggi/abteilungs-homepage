<template>
    <div class="lightbox" style="display: block">
        <div @click="hide" class="lightbox__background"></div>
        <div class="lightbox__content-wrapper" >
            <div class="lightbox__content agenda__detail">
                <div class="lightbox__banner agenda__header">
                    <div class="agenda__header-text">
                        <h3>{{event.name}}</h3>
                        <p v-if="!special && event.start_location">Start: {{getDate(event.start_time)}} {{getTime(event.start_time)}} {{event.start_location.name}}</p>
                        <p v-if="!special && event.end_location">Ende: {{getDate(event.end_time)}} {{getTime(event.end_time)}} {{event.end_location.name}}</p>
                    </div>
                    <img style="height: 50px" :src="settings.logo.data.full_url" alt="Abteilungs-Logo">
                </div>
                <div class="lightbox__body">
                    <div class="agenda__map" v-if="!special">
                        <swisstopo-map :settings="settings"
                             :start-loc="startLoc"
                             :end-loc="endLoc"></swisstopo-map>
                    </div>

                    <div class="agenda__body">
                        <div class="lightbox__section" v-html="event.description">
                        </div>
                        <div class="lightbox__section" >
                            <p >Hast du noch Fragen? Dann melde dich bei
                                <a v-if="!special" :href="'mailto:'+group.contact_email">{{group.contact_name}}</a>
                                <a v-else :href="'mailto:'+settings.event_email">{{settings.event_email}}</a>
                            </p>
                        </div>
                        <div class="lightbox__section" v-if="!special">
                            <h4>Mitnehmen</h4>
                            <div v-html="event.bring"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import SwisstopoMap from "./SwisstopoMap";
import { get } from 'lodash'
export default {
    name: "LightboxAgenda",
    components: {SwisstopoMap},
    props: ["event", "settings", "group", "special"],
    computed: {
        startLoc() {
            return get(this.event, 'start_location.location')
        },
        endLoc() {
            return get(this.event, 'end_location.location')
        }
    },
    methods: {
        get,
        hide() {
            this.$emit('hide', 'true')
        },
        getDate(time) {
            const options = {year: '2-digit', month: '2-digit', day: 'numeric'};
            return (new Date(time)).toLocaleDateString('de-CH', options)
        },
        getTime(time) {
            const options = {hour: '2-digit', minute: '2-digit'};
            return (new Date(time)).toLocaleTimeString('de-CH', options)
        },
    },
}
</script>

<style scoped>

</style>