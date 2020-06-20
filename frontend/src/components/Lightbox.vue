<template>
    <div class="lightbox" style="display: block">
        <div @click="hide" class="lightbox__background"></div>
        <div class="lightbox__content-wrapper">
            <div class="lightbox__content">
                <div class="lightbox__banner group__detail-banner">
                    <h2 class="heading-2--inverted">{{group.name}}</h2>
                    <div class="circle-small" style="background-color: #ddaa33;">
                        <img :src="group.logo.data.full_url">
                    </div>
                </div>
                <div class="lightbox__body groupdetail__body">
                    <div class="lightbox__section">
                        <div>
                            <div class="group__info-box">
                                <p><b>Alter:</b> {{age_level.age_min}} - {{age_level.age_max}} Jahre</p>
                                <p><b>Geschlecht:</b> {{parseGender(group.gender)}}</p>
                                <p><b>Region:</b> {{group.area}}</p>
                                <p><b>Vorgängergruppe:</b></p>
                                <ul>
                                    <li><a href="#v">Vorgänger</a></li>
                                </ul>
                                <p><b>Nachfolgergruppe:</b></p>
                                <ul>
                                    <li><a href="#n">Nachfolger</a></li>
                                </ul>
                                <p><b>Kontakt:</b> <a
                                        :href="'mailto:'+group.contact_email">{{group.contact_name}}</a>
                                </p>
                            </div>
                            <div class="group__pictures">
                                <img class="group__picture" alt=""
                                     src="#">
                            </div>
                        </div>
                        <div class="content__column">
                            <a href="#" class="button button--small">Mitmachen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Lightbox",
        props: ["group", "age_levels"],
        data() {
            return {
                age_level: {}
            }
        },
        methods: {
            hide() {
                this.$emit('hide', 'true')
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

            }
        },
        created() {
            this.findGroupAgeLevel()
        }
    }
</script>

<style scoped>

</style>