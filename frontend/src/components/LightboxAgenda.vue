<template>
    <div class="lightbox" style="display: block">
        <div @click="hide" class="lightbox__background"></div>
        <div class="lightbox__content-wrapper">
            <div class="lightbox__content agenda__detail">
                <div class="lightbox__banner agenda__header">
                    <div class="agenda__header-text">
                        <h3>{{event.name}}</h3>
                        <p>Start: {{getDate(event.start_time)}} {{getTime(event.start_time)}}</p>
                        <p>Stop: {{getDate(event.end_time)}} {{getTime(event.end_time)}}</p>
                    </div>
                    <img style="height: 50px" :src="settings[0].logo.data.full_url" alt="Abteilungs-Logo">
                </div>
                <div class="lightbox__body">
                    <div class="agenda__map">

                    </div>
                    <div class="agenda__body">
                        <div class="lightbox__section">
                        </div>
                        <div class="lightbox__section"></div>
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
    export default {
        name: "LightboxAgenda",
        props: ["event", "settings"],
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