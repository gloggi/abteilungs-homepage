<template>
    <div class="footer">
        <div class="footer__content">
                <div class="footer__column">
                    <h3 class="heading--footer">{{settings.footer_group_list_title}}</h3>
                    <ul>
                        <template v-for="{group, children} in groupHierarchy">
                            <li :key="group.name"><router-link :to="{ path: '/'+settings.footer_group_links_page.route+'/gruppe/'+group.name.split(' ').join('-') }">{{group.name}}</router-link></li>
                            <ul :key="'sub-'+group.name">
                                <li v-for="child in children" :key="child.name">
                                    <router-link :to="{ name: settings.footer_group_links_page.name, hash: slug(child) }">{{child.name}}</router-link>
                                </li>
                            </ul>
                        </template>
                    </ul>
                </div>
            <div class="footer__column" v-if="settings.footer_links">
                <h3 class="heading--footer">Links</h3>
                <ul>
                    <li v-for="(link, index) in settings.footer_links" :key="index">
                        <a :href="link.url">{{link.name}}</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3 class="heading--footer">Kontakt</h3>
                <div v-html="settings.footer_contact"></div>
            </div>
        </div>
    </div>
</template>

<script>
import slugify from 'slugify'

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
                .map(group => ({[group.name]: {
                    group: group,
                    children: this.groups.filter(child => child.parent_group && child.parent_group.id === group.id)
                }})))
        }
    },
    methods: {
        slug(group) {
            return '#' + slugify(group.name, { lower: true })
        }
    },
    created() {

    }
}
</script>

<style scoped>

</style>