<template>
    <div>
    <div class="content__block">
        <div class="agenda">
            <div class="agenda__sections">
                <a @click="setGroup(group)" v-for="group in groups"
                   class="agenda__section button--inactive select" :id="group.name" href="#"
                   :data-showclass="group.name" :key="group.id">{{group.name}}</a>
            </div>
        </div>
        <p v-if="entry_text">Wähle eine Gruppe aus, um ihre Einträge anzuzeigen.</p>
        <div v-if="Object.keys(next_event).length !== 0" class="agenda__entries-first" id="naechster-anlass">
            <div class="agenda__entry">
                <a @click="selectEvent(next_event)" href="#">
                    <div class="circle-small color-primary" style="">
                        <p>{{getDate(next_event.start_time)}}</p>
                    </div>
                </a>
                <div class="agenda__entry-content">
                    <a @click="selectEvent(next_event)" href="#">
                        <h3>{{next_event.name}}</h3>
                        <p class="agenda__date">{{listGroups(next_event)}}, {{getDate(next_event.start_time)}}</p>
                        <div v-html="next_event.description"></div>
                    </a>
                    <a @click="selectEvent(next_event)" href="#">Mehr &gt;&gt;</a>
                </div>
            </div>
        </div>
        <div class="agenda__entries">
            <div v-for="event in other_events" class="agenda__entry" :key="event.id">
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
                    <a @click="selectEvent(next_event)" href="#">Mehr &gt;&gt;</a>
                </div>
            </div>

        </div>
        <lightbox-agenda v-if="lightbox_show" @hide="lightbox_show=false" :event="active_event" :settings="settings"></lightbox-agenda>
    </div>
    <div v-if="!entry_text" class="content__block">
        <h2 class="heading-2">
            Jahresplan der Gruppe
        </h2>
        <ul class="agenda__year-agenda">
            <li class="annualplan">
                <a href="#">
                    <img class="agenda__anualplan svg" src="../assets/img/doc.svg">
                    <p>{{active_group.name}}</p>
                </a>
            </li>
        </ul>
    </div>
        <div class="content__block">
            <h2 class="heading-2">Wichtige Pfadianlässe</h2>
            <ul class="agenda__special-events">
                <li v-for="special_event in special_events" :key="special_event.id">
                    <a href="#">
                        <div class="circle-medium color-primary">
                            <p>{{special_event.name}}</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import LightboxAgenda from "./LightboxAgenda";
    export default {
        name: "Agenda",
        components: {LightboxAgenda},
        props: ["groups", "agenda_sections", "locations", "special_events", "events", "settings"],
        data() {
            return {
                active_group: {},
                next_event:{},
                other_events:[],
                entry_text: true,
                active_event: {},
                lightbox_show: false

            }
        },
        methods: {
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
            hasPassed(time) {
                var n = new Date(Date.now())
                var d = new Date(time)
                return n - d > 0
            },
            setGroup(group){
                this.active_group=group
                this.entry_text=false
                this.next_event= {}
                this.other_events = []
                var flag = true
                for(let i =0;i<this.events.length;i=i+1){
                    for(let j=0;j<this.events[i].participating_groups.length;j=j+1){
                        if(!this.hasPassed(this.events[i].end_time)&&this.events[i].participating_groups[j].group.id==group.id){
                            if(flag){
                            this.next_event=this.events[i]
                                flag= false
                            }else{
                                this.other_events.push(this.events[i])
                            }

                        }
                    }
                }

            },
            listGroups(event){
                var groups = []
                event.participating_groups.forEach(function (item) {
                    groups.push(item.group.name)
                })
                return groups.join(", ")
            },
            selectEvent(event){
                this.active_event = event
                this.lightbox_show=true

            }

        }
    }
</script>

<style scoped>

</style>