<template>
    <div class="footer">
        <div class="footer__content">
                <div class="footer__column">
                    <h3 class="heading--footer">{{settings[0].footer_group_list_title}}</h3>
                    <ul>
                        <template v-for="(value, key) in groupHierarchy">
                            <li :key="key"><router-link :to="'/'+settings[0].footer_group_links_page.route">{{key}}</router-link></li>
                            <ul :key="'sub-'+key">
                                <li v-for="group in value" :key="group.name">
                                    <router-link :to="'/'+settings[0].footer_group_links_page.route">{{group.name}}</router-link>
                                </li>
                            </ul>
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
        groupHierarchy() {
            return Object.assign(...this.groups
                .filter(group => !group.parent_group)
                .map(group => ({ [group.name]: this.groups.filter(child => child.parent_group && child.parent_group.id === group.id) })))
        }
    },
    created() {

    }
}
</script>

<style scoped>

</style>