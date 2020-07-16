<template>
    <div>
        <!-- Groups -->
        <div class="content__block">
            <div class="agenda">
                <div class="agenda__sections">
                    <a v-for="group in groups" @click.prevent="selectGroup(group)"
                       class="agenda__section button--inactive select" :id="group.name" href="#"
                       :data-showclass="group.name" :key="group.id">{{group.name}}</a>
                </div>
            </div>
        </div>
        <!-- Agenda Entries -->
        <template v-for="section in agendaSections">
            <template v-if="section.type=='events'">
                <!-- First Entry -->
                <div class="content__block" :key="section.id">
                    <p v-if="!activeGroup">Wähle eine Gruppe aus, um ihre Einträge anzuzeigen.</p>
                    <div v-if="nextEvent" class="agenda__entries-first" id="naechster-anlass">
                        <div class="agenda__entry">
                            <a @click="selectEvent(nextEvent)" href="#">
                                <div class="circle-small color-primary" style="">
                                    <p>{{getDate(nextEvent.start_time)}}</p>
                                </div>
                            </a>
                            <div class="agenda__entry-content">
                                <a @click="selectEvent(nextEvent)" href="#">
                                    <h3>{{nextEvent.name}}</h3>
                                    <p class="agenda__date">{{listGroups(nextEvent)}},
                                        {{getDate(nextEvent.start_time)}}</p>
                                    <div v-html="nextEvent.description"></div>
                                </a>
                                <a @click="selectEvent(nextEvent)" href="#">Mehr &gt;&gt;</a>
                            </div>
                        </div>
                    </div>
                    <!-- Other Entries -->
                    <div class="agenda__entries">
                        <div v-for="event in otherEvents" class="agenda__entry" :key="event.id">
                            <a @click="selectEvent(event)" href="#">
                                <div class="circle-small color-primary" style="">
                                    <p>{{getDate(event.start_time)}}</p>
                                </div>
                            </a>
                            <div class="agenda__entry-content">
                                <a @click="selectEvent(event)" href="#">
                                    <h3>{{event.name}}</h3>
                                    <p class="agenda__date">{{listGroups(event)}}, {{getDate(event.start_time)}}</p>
                                    <div v-html="event.description"></div>
                                </a>
                                <a @click="selectEvent(nextEvent)" href="#">Mehr &gt;&gt;</a>
                            </div>
                        </div>

                    </div>
                </div>
            </template>

            <!-- Anual Plan -->
            <template v-if="section.type=='anual_plan' && annualPlan">
                <div v-if="activeGroup" class="content__block" :key="section.id">
                    <h2 class="heading-2">
                        Jahresplan der Gruppe
                    </h2>
                    <ul class="agenda__year-agenda">
                        <li class="annualplan">
                            <a :href="annualPlan.data.full_url">
                                <img class="agenda__anualplan svg" src="../assets/img/doc.svg">
                                <p>{{activeGroup.name}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </template>
            <!-- Special Events -->
            <template v-if="section.type=='special_events'">
                <div class="content__block" :key="section.id">
                    <h2 class="heading-2">Wichtige Pfadianlässe</h2>
                    <ul class="agenda__special-events">
                        <li v-for="specialEvent in specialEvents" :key="specialEvent.id">
                            <a @click="selectEvent(specialEvent)" href="#">
                                <div class="circle-medium color-primary">
                                    <p>{{specialEvent.name}}</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </template>
        </template>
        <!-- Agenda Lightbox -->
        <lightbox-agenda v-if="activeEvent" @hide="activeEvent=null" :event="activeEvent"
                         :group="activeGroup" :special="isSpecial" :settings="settings"></lightbox-agenda>
    </div>
</template>


<script>
import LightboxAgenda from './LightboxAgenda';
import { get } from 'lodash'

export default {
    name: "Agenda",
    components: {LightboxAgenda},
    props: ["groups", "agendaSections", "locations", "specialEvents", "events", "settings"],
    data() {
        return {
            activeGroup: null,
            activeEvent: null,
            isSpecial: false
        }
    },
    computed: {
        allEvents() {
            if (!this.activeGroup) return []
            return this.events
                .filter(event => event.participating_groups.some(group => group.group.id === this.activeGroup.id))
        },
        nextEvent() {
            return this.allEvents.length ? this.allEvents[0] : null
        },
        otherEvents() {
            return this.allEvents.slice(1)
        },
        annualPlan() {
            return get(this.activeGroup, 'annualPlan')
        }
    },
    methods: {
        getDate(time) {
            const options = {year: '2-digit', month: '2-digit', day: 'numeric'}
            return (new Date(time)).toLocaleDateString('de-CH', options)
        },
        getTime(time) {
            const options = {hour: '2-digit', minute: '2-digit'}
            return (new Date(time)).toLocaleTimeString('de-CH', options)
        },
        listGroups(event) {
            return event.participating_groups.map(group => group.group.name).join(', ')
        },
        selectGroup(group) {
            this.activeGroup = group
        },
        selectEvent(event) {
            this.activeEvent = event
            this.isSpecial = !('start_time' in event);
        }

    }
}
</script>

<style scoped>

</style>