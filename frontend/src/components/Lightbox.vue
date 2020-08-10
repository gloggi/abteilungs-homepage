<template>
    <div class="lightbox" style="display: block">
        <div @click="hide" class="lightbox__background"></div>
        <div class="lightbox__content-wrapper">
            <div class="lightbox__content">
                <div class="lightbox__banner group__detail-banner">
                    <h2 class="heading-2--inverted">{{group.name}}</h2>
                    <div class="circle-small" style="background-color: #ddaa33;">
                        <img v-if="group.logo" :src="group.logo.data.full_url">
                    </div>
                </div>
                <div class="lightbox__body groupdetail__body">
                    <div class="lightbox__section">
                        <div :class="group.description?'content__columns content__columns--1-1':''">
                            <div class="content__column" v-if="group.description">
                                <div v-html="group.description"></div>
                                <a href="#" class="button button--small">Mitmachen</a>
                            </div>
                            <div>
                                <div class="group__info-box">
                                    <p><b>Alter:</b> {{ageLevel.age_min}} - {{ageLevel.age_max}} Jahre</p>
                                    <p><b>Geschlecht:</b> {{parseGender(group.gender)}}</p>
                                    <p><b>Region:</b> {{group.area}}</p>
                                    <template v-if="groupChildren.length>0">
                                        <p><b>Untergruppen:</b></p>
                                        <ul>
                                            <li v-for="child in groupChildren" :key="child.id"><a
                                                    @click="changeGroup(child.id)">{{child.name}}</a></li>
                                        </ul>
                                    </template>
                                    <p><b>Vorgängergruppe:</b></p>
                                    <ul>
                                        <template v-if="predecessorGroups.length>0">
                                            <li v-for="item in predecessorGroups" :key="item.id">
                                                <a href="#v" @click="changeGroup(item.id)">{{item.name}}</a></li>
                                        </template>
                                        <li v-else>-</li>
                                    </ul>
                                    <p><b>Nachfolgergruppe:</b></p>
                                    <ul>
                                        <li v-if="group.successor_groups.length>0&&group.successor_groups[0].successor_group.name!=group.name">
                                            <a @click="changeGroup(group.successor_groups[0].successor_group.id)"
                                               href="#n">{{group.successor_groups[0].successor_group.name}}</a></li>
                                        <li v-else>-</li>
                                    </ul>
                                    <p><b>Kontakt:</b> <a
                                            :href="'mailto:'+group.contact_email">{{group.contact_name}}</a>
                                    </p>
                                </div>
                                <div class="group__pictures" v-if="group.images.length>0">
                                    <img v-for="image in group.images" :key="image.image.id" class="group__picture" alt=""
                                         :src="image.image.data.full_url">
                                </div>
                            </div>
                        </div>
                        <div class="lightbox__section"><h3>Nächste Anlässe</h3></div>
                        <div class="eventslist-list-entry lightbox__section agenda__entry" v-for="event in allEvents" :key="event.id">
                            <router-link :to="{path: group.name.split(' ').join('-')+'/event/'+event.id}">
                                <div class="circle-small color-primary" style="">
                                    <p>{{getDate(event.start_time)}}</p>
                                </div>
                            </router-link>
                            <div class="agenda__entry-content">
                                <router-link :to="{path: group.name.split(' ').join('-')+'/event/'+event.id}">
                                    <h3>{{event.name}}</h3>
                                    <p class="agenda__date">{{listGroups(event)}}, {{getDate(event.start_time)}}</p>
                                    <div v-html="event.description"></div>
                                </router-link>
                                <router-link :to="{path: group.name.split(' ').join('-')+'/event/'+event.id}">Mehr &gt;&gt;</router-link>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <lightbox-agenda v-if="activeEvent" @hide="hideAgendaLightBox" :event="activeEvent"
                         :group="group" :special="false" :settings="settings"></lightbox-agenda>
    </div>
</template>

<script>
import LightboxAgenda from "./LightboxAgenda";
export default {
    name: "Lightbox",
    components: {LightboxAgenda},
    props: ["group", "ageLevels", "groups", "events", "settings"],
    data() {
        return {
            activeEvent: null
        }
    },
    methods: {
        hide() {
            this.$emit('hide', 'true')
        },
        changeGroup(group_id) {
            this.$emit('change', group_id)
        },
        parseGender(g) {
            return { 'm': 'Jungs', 'w': 'Mädchen', 'b': 'Gemischte Gruppe' }[g]
        },
        getDate(time) {
            const options = {year: '2-digit', month: '2-digit', day: 'numeric'};
            return (new Date(time)).toLocaleDateString('de-CH', options)
        },
        selectEvent(event) {
            this.activeEvent = event
        },
        listGroups(event) {
            return event.participating_groups.map(group => group.group.name).join(', ')
        },
        hideAgendaLightBox(){
            this.activeEvent=null
            this.$router.back()
        }
    },
    computed: {
        ageLevel() {
            return this.ageLevels.find(ageLevel => ageLevel.id === this.group.age_level.id)
        },
        allEvents() {
            return this.events
                .filter(event => event.participating_groups.some(group => group.id === this.group.id))
        },
        groupChildren() {
            return this.groups
                .filter(group => group.parent_group && group.parent_group.id === this.group.id)
                .map(group => ({ id: group.id, name: group.name }))
        },
        predecessorGroups() {
            return this.groups
                .filter(group => group.successor_group && group.successor_group.id === this.group.id)
                .map(group => ({ id: group.id, name: group.name }))
        }
    },
    watch:{
        $route(){
            if(this.$route.params.router_event){
                var event = this.allEvents.find(event => event.id === parseInt(this.$route.params.router_event))
                this.selectEvent(event)
            }

        }
    },
    created() {
        if(this.$route.params.router_event){
            var event = this.allEvents.find(event => event.id === parseInt(this.$route.params.router_event))
            this.selectEvent(event)
        }
    }
}
</script>

<style scoped>

</style>