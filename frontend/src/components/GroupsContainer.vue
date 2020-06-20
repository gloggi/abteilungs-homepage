<template>
    <div class="groups__container">
        <template v-for="age_level in age_levels">
            <div class="groups__section" :style="'background-color:'+ age_level.color" :key="age_level.id">
                <div class="groups__section-icon">
                    <img :src="age_level.logo.data.full_url" alt="">
                    <div>
                        <h3>{{age_level.name}}</h3>
                        <p>{{age_level.age_min}} - {{age_level.age_max}} Jahre</p>
                    </div>
                </div>
                <div class="groups__section-entries">
                    <template v-for="group in groups">
                        <a @click="showLightBox(group.id)" :title="group.id" v-if="age_level.id==group.age_level.id"
                           :key="group.id">
                            <div class="groups__entry">
                                <div class="circle-medium" :style="'background-color: '+group.color">
                                    <img :src="group.logo.data.full_url" alt="">
                                </div>
                                <div class="circle-notification">
                                    <img v-if="group.gender=='b'" src="../assets/img/b.svg" alt="">
                                    <img v-if="group.gender=='m'" src="../assets/img/m.svg" alt="">
                                    <img v-if="group.gender=='w'" src="../assets/img/f.svg" alt="">
                                </div>
                            </div>
                        </a>
                        <lightbox @hide="active_lightbox=0" v-if="active_lightbox==group.id" :group="group"
                                  :age_levels="age_levels" :key="'lb-'+group.id"></lightbox>
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
        props: ["age_levels", "groups"],
        data() {
            return {
                active_lightbox: 0

            }
        },
        methods: {
            showLightBox(id) {
                this.active_lightbox = id
            }

        }
    }
</script>

<style scoped>

</style>