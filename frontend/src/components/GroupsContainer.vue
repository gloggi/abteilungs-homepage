<template>
    <div class="groups__container">
        <template v-for="ageLevel in ageLevels">
            <div class="groups__section" :style="'background-color:'+ ageLevel.color" :key="ageLevel.id">
                <div class="groups__section-icon">
                    <img v-if="ageLevel.logo" :src="ageLevel.logo.data.full_url" alt="">
                    <div>
                        <h3>{{ageLevel.name}}</h3>
                        <p>{{ageLevel.age_min}} - {{ageLevel.age_max}} Jahre</p>
                    </div>
                </div>
                <div class="groups__section-entries">
                    <template v-for="group in groups.filter(group => group.age_level.id === ageLevel.id && !group.parent_group)">
                        <router-link :to="{path: $route.path+'/gruppe/'+group.name.split(' ').join('-')}" :title="group.id"
                           :key="group.id">
                            <div class="groups__entry">
                                <div class="circle-medium" :style="'background-color: '+group.color">
                                    <img v-if="group.logo" :src="group.logo.data.full_url" alt="">
                                </div>
                                <div class="circle-notification">
                                    <img v-if="group.gender=='b'" src="../assets/img/b.svg" alt="">
                                    <img v-if="group.gender=='m'" src="../assets/img/m.svg" alt="">
                                    <img v-if="group.gender=='w'" src="../assets/img/f.svg" alt="">
                                </div>
                            </div>
                        </router-link>
                        <lightbox v-if="activeLightbox===group.id" @hide="hideLightBox" @change="showLightBox" :group="group"
                                  :age-levels="ageLevels" :settings="settings" :events="events" :groups="groups" :key="'lb-'+group.id"></lightbox>
                    </template>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import Lightbox from "./Lightbox";

export default {
    name: "GroupsContainer",
    components: {Lightbox},
    props: ["ageLevels", "groups", "events", "settings"],
    data() {
        return {
            activeLightbox: null
        }
    },
    methods: {
        showLightBox(id) {
            this.activeLightbox = id
        },
        hideLightBox(){
            this.activeLightbox=null
            this.$router.back()
        }
    },
    watch:{
        $route(){
            if(this.$route.params){
                var group = this.groups.find(group => group.name === this.$route.params.router_group.split("-").join(" "))
                this.showLightBox(group.id)
            }

        }
    },
    created() {
        if(this.$route.params){
            var group = this.groups.find(group => group.name === this.$route.params.router_group.split("-").join(" "))
            this.showLightBox(group.id)
        }
    }
}
</script>

<style scoped>

</style>