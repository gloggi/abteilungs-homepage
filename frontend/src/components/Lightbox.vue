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
                        <div class="content__columns content__columns--1-1">
                            <div class="content__column" v-if="group.description">
                                <div v-html="group.description"></div>
                                <a href="#" class="button button--small">Mitmachen</a>
                            </div>
                            <div>
                                <div class="group__info-box">
                                    <p><b>Alter:</b> {{age_level.age_min}} - {{age_level.age_max}} Jahre</p>
                                    <p><b>Geschlecht:</b> {{parseGender(group.gender)}}</p>
                                    <p><b>Region:</b> {{group.area}}</p>
                                    <template v-if="GroupChildren.length>0">
                                        <p><b>Untergruppen:</b></p>
                                        <ul>
                                            <li v-for="child in GroupChildren" :key="child.id"><a
                                                    @click="changeGroup(child.id)">{{child.name}}</a></li>
                                        </ul>
                                    </template>
                                    <p><b>Vorgängergruppe:</b></p>
                                    <ul>
                                        <template v-if="predecessorGroup.length>0">
                                            <li v-for="item in predecessorGroup" :key="item.id">
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
                        <div class="eventslist-list-entry lightbox__section agenda__entry" v-for="event in all_events" :key="event.id">
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
                                <a @click="selectEvent(event)" href="#">Mehr &gt;&gt;</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <lightbox-agenda v-if="lightbox_show" @hide="lightbox_show=false" :event="active_event"
                         :group="group" :special="false" :settings="settings"></lightbox-agenda>
    </div>
</template>

<script>
    import LightboxAgenda from "./LightboxAgenda";
    export default {
        name: "Lightbox",
        components: {LightboxAgenda},
        props: ["group", "age_levels", "groups", "events", "settings"],
        data() {
            return {
                age_level: {},
                all_events: [],
                active_event:{},
                lightbox_show: false
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
                switch (g) {
                    case "m":
                        return "Jungs"
                    case "w":
                        return "Mädchen"
                    case "b":
                        return "Gemischte Gruppe"

                }
            },
            findGroupAgeLevel() {
                var vm = this;
                this.age_levels.forEach(function (item) {
                    if (item.id == vm.group.age_level.id) {
                        vm.age_level = item
                    }
                })

            },
            loadEvents() {
                var group = this.group
                this.all_events = []
                for (let i = 0; i < this.events.length; i = i + 1) {
                    for (let j = 0; j < this.events[i].participating_groups.length; j = j + 1) {
                        if (!this.hasPassed(this.events[i].end_time) && this.events[i].participating_groups[j].group.id == group.id) {
                                this.all_events.push(this.events[i])
                        }
                    }
                }

            },
            getDate(time) {
                const options = {year: '2-digit', month: '2-digit', day: 'numeric'};
                var d = new Date(time)
                return d.toLocaleDateString('de-CH', options)
            },
            hasPassed(time) {
                var n = new Date(Date.now())
                var d = new Date(time)
                return n - d > 0
            },
            selectEvent(event) {
                this.active_event = event
                this.lightbox_show = true
            },
            listGroups(event) {
                var groups = []
                event.participating_groups.forEach(function (item) {
                    groups.push(item.group.name)
                })
                return groups.join(", ")
            }
        },
        computed: {
            GroupChildren() {
                var group_name = this.group.name
                var children = []
                this.groups.forEach(function (item) {
                    if (item.parent_group && item.parent_group.name == group_name) {
                        children.push({name: item.name, id: item.id})

                    }

                })
                return children

            },
            predecessorGroup() {
                var group_id = this.group.id
                var predecessors = []
                var temp_group = ""
                this.groups.forEach(function (item) {
                    temp_group = item
                    item.successor_groups.forEach(function (item) {
                        if ('successor_group' in item && item.successor_group.id == group_id) {
                            predecessors.push({name: temp_group.name, id: temp_group.id})
                        }
                    })

                })
                return predecessors

            }
        },
        created() {
            this.findGroupAgeLevel()
            this.loadEvents()
        }
    }
</script>

<style scoped>

</style>