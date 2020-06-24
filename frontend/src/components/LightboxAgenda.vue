<template>
    <div class="lightbox" style="display: block">
        <div @click="hide" class="lightbox__background"></div>
        <div class="lightbox__content-wrapper">
            <div class="lightbox__content agenda__detail">
                <div class="lightbox__banner agenda__header">
                    <div class="agenda__header-text">
                        <h3>{{event.name}}</h3>
                        <p>Start: {{getDate(event.start_time)}} {{getTime(event.start_time)}} {{event.start_location.name}}</p>
                        <p>Stop: {{getDate(event.end_time)}} {{getTime(event.end_time)}} {{event.end_location.name}}</p>
                    </div>
                    <img style="height: 50px" :src="settings[0].logo.data.full_url" alt="Abteilungs-Logo">
                </div>
                <div class="lightbox__body">
                    <div class="agenda__map">
                        <Map :start_loc_lat="event.start_location.location.lat"
                             :start_loc_lng="event.start_location.location.lng"
                             :end_loc_lat="event.end_location.location.lat"
                             :end_loc_lng="event.end_location.location.lng"></Map>
                    </div>
                    <div class="agenda__body">
                        <div class="lightbox__section" v-html="event.description">
                        </div>
                        <div class="lightbox__section">
                            <p>Hast du noch Fragen? Dann melde dich bei <a :href="'mailto:'+group.contact_email">{{group.contact_name}}</a></p>
                        </div>
                        <div class="lightbox__section">
                            <h4>Mitnehmen</h4>
                            <div v-html="event.bring">Test</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Map from "./Map";
    export default {
        name: "LightboxAgenda",
        components: {Map},
        props: ["event", "settings", "group"],
        data() {
            return {
                age_level: {}
            }
        },
        methods: {
            hide() {
                this.$emit('hide', 'true')
            },
            getDate(time) {
                const options = {year: '2-digit', month: '2-digit', day: 'numeric'};
                var d = new Date(time)
                return d.toLocaleDateString('de-CH', options)
            },
            getTime(time) {
                const options = {hour: '2-digit', minute: '2-digit'};
                var d = new Date(time)
                return d.toLocaleTimeString('de-CH', options)
            },

        },
        created() {

        }
    }
</script>

<style scoped>

</style>