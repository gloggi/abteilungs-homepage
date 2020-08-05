<template>
    <div id="app" v-if="loaded"
         :style="'--primary-color: '+settings.primary_color+';--secondary-color: '+settings.secondary_color">
        <Header :page="page" :settings="settings"></Header>
        <Navbar :pages="pages" :settings="settings"></Navbar>
        <router-view :page="page"
                     :age-levels="ageLevels"
                     :groups="groups"
                     :contacts="contacts"
                     :events="events"
                     :special-events="specialEvents"
                     :locations="locations"
                     :settings="settings"></router-view>
        <Footer :groups="groups" :settings="settings"></Footer>
    </div>
</template>

<script>
import Page from './components/Page'
import Header from './components/Header'
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import NotFound from './components/NotFound';
import { camelCase, get } from 'lodash';

const itemsToLoad = {
    pages: '',
    settings: '',
    age_levels: '',
    contacts: '',
    events: 'filter[end_time][gte]=now',
    groups: '',
    locations: '',
    special_events: ''
};

export default {
    name: 'App',
    components: {
        Footer,
        Navbar,
        Header
    },
    data() {
        return {
            ageLevels: null,
            contacts: null,
            events: null,
            groups: null,
            locations: null,
            allPages: null,
            allSettings: null,
            specialEvents: null
        }
    },
    metaInfo() {
        return {
            title: `${this.scoutGroupName} | ${this.page.name}`,
            htmlAttrs: {
                lang: 'de',
                amp: true
            },
            link: [
                {rel: 'icon', type: 'image/png', href: this.favicon}
            ]
        }
    },
    methods: {
        async getItems(item, query) {
            if (query) query = '&' + query
            return (await this.$http.get('items/' + item + '?fields=*.*.*' + query)).data.data
        },
        loadData() {
            Object.entries(itemsToLoad).forEach(async ([item, query]) => {
                this[camelCase(item)] = await this.getItems(item, query)
            })
        }
    },
    computed: {
        page() {
            if (!this.pages) return {}
            return this.pages.find(page => this.$route.name === page.name) || {}
        },
        pages: {
            get() {
                return this.allPages
            },
            set(pages) {
                if (pages.length) pages[0].route = ''
                this.allPages = pages
                const routes = this.allPages
                    .map(page => ({ path: '/' + page.route, name: page.name, component: Page }))
                    .concat([{ path: '*', name: '404', component: NotFound }])
                this.$router.addRoutes(routes)
            }
        },
        settings: {
            get() {
                return this.allSettings
            },
            set(settings) {
                if (settings.length) this.allSettings = settings[0]
                else this.allSettings = null
            }
        },
        loaded() {
            return Object.keys(itemsToLoad).every(item => this[camelCase(item)] !== null)
        },
        scoutGroupName() {
            return get(this.settings, '[0].scout_group_name', 'Pfadiabteilung')
        },
        favicon() {
            return get(this.settings, '[0].favicon.data.full_url', '')
        }
    },
    created() {
        this.loadData();
    }

}
</script>

<style>
    @import './assets/css/bootstrap.min.css';
    @import './assets/css/main.css';

    :root {
        --primary-color: grey;
        --secondary-color: grey;
    }

    .color-primary, .body, .navbar, #navbar, .button, .lightbox__banner, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-right, .group__detail-banner {
        background-color: var(--primary-color) !important;
    }

    .agenda__year-agenda li a p {
        color: var(--primary-color) !important;
    }

    .button--inactive, .agenda__entry-content > a {
        color: var(--primary-color) !important;
    }

    .form-control {
        border-color: var(--primary-color);
    }

    .group__info-box, .button:focus, .button--inactive:focus {
        border-color: var(--primary-color) !important;
    }

    .navbar-toggle:active, .navbar-toggle:hover, .navbar-toggle:focus {
        background-color: var(--primary-color) !important;
    }

    h2, h3, h4 {
        color: var(--primary-color) !important;
    }

    .heading-2--inverted {
        color: white !important;
    }

    .svg path {
        fill: var(--primary-color) !important;
    }

    .color-secondary, ::selection, a:hover, a ::selection, .text--question, .agenda__body b, .navbar-default .navbar-nav > li > a:hover {
        color: var(--secondary-color) !important;
    }

    .button:active, .button--inactive:active, .icon-bar, .circle-notification {
        background-color: var(--secondary-color) !important;
    }

    .form-control:focus, .navbar-toggle {
        border-color: var(--secondary-color) !important;
    }
</style>
