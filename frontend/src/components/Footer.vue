<template>
    <div class="footer">
        <div class="footer__content">
                <div class="footer__column">
                    <h3 class="heading--footer">{{settings[0].footer_group_list_title}}</h3>
                    <ul>
                        <template v-for="(value, key) in getGroupHierarchy">
                            <li :key="key"><router-link :to="'/'+settings[0].footer_group_links_page.route">{{key}}</router-link></li>
                            <template v-if="value">
                                <ul :key="'sub-'+key">
                                    <li v-for="group in value" :key="group">
                                        <router-link :to="'/'+settings[0].footer_group_links_page.route">{{group}}</router-link></li>
                                </ul>
                            </template>
                        </template>
                    </ul>
                </div>
            <div class="footer__column" v-if="settings[0].footer_links">
                <h3 class="heading--footer">Links</h3>
                <ul>
                    <li v-for="(link, index) in settings[0].footer_links" :key="index">
                        <a :href="link.url">{{link.name}}</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3 class="heading--footer">Kontakt</h3>
                <div v-html="settings[0].footer_contact"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Footer",
        props: ['groups', 'settings'],
        data() {
            return {}
        },
        computed: {
            getGroupHierarchy() {
                var groups = this.groups;
                var ord_groups = {}
                var temp = []
                groups.forEach(function (item) {
                    if (item.parent_group) {
                        if (item.parent_group.name in ord_groups) {
                            temp = ord_groups[item.parent_group.name]
                            if (!temp) {
                                temp = []
                            }
                            temp.push(item.name)
                            ord_groups[item.parent_group.name] = temp
                        } else {
                            temp = []
                            temp.push(item.name)
                            ord_groups[item.parent_group.name] = temp;

                        }
                    } else {
                        if (!(item.name in ord_groups)) {
                            ord_groups[item.name] = null
                        }
                    }


                })
                return ord_groups

            }
        },
        created() {

        }
    }
</script>

<style scoped>

</style>