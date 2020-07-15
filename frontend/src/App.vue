<template>
    <div id="app" v-if="loaded"
         :style="'--primary-color: '+settings[0].primary_color+';--secondary-color: '+settings[0].secondary_color">
        <Header :page="page" :pages="pages"
                :settings="settings"></Header>
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
import { camelCase, isEmpty, get } from 'lodash';

export default {
    name: 'App',
    components: {
        Footer,
        Navbar,
        Header
    },
    data() {
        return {
            items: ['age_levels', 'contacts', 'events', 'groups', 'locations', 'pages', 'settings', 'special_events'],
            ageLevels: [],
            contacts: [],
            events: [],
            groups: [],
            locations: [],
            pages: [],
            settings: [],
            specialEvents: []
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
        async getItems(item) {
            this[camelCase(item)] = (await this.$http.get('items/' + item + '?fields=*.*.*')).data.data
        },
        loadData() {
            this.items.forEach(item => this.getItems(item))
        },
        createRoute(route, name, show, component) {
            this.$router.addRoutes([{ path: `/${route}`, component, name }])
        }
    },
    computed: {
        page() {
            return this.pages.find(page => this.$route.name === page.name) || {}
        },
        loaded() {
            return this.items.every(item => !isEmpty(this[camelCase(item)]))
        },
        scoutGroupName() {
            return get(this.settings, '[0].scout_group_name', 'Pfadiabteilung')
        },
        favicon() {
            return get(this.settings, '[0].favicon.data.full_url', '')
        }
    },
    watch: {
        pages() {
            if (this.pages.length) this.createRoute('', this.pages[0].name, this.pages[0].show_in_navigation_bar, Page)
            this.pages.slice(1).forEach(page => this.createRoute(page.route, page.name, page.show_in_navigation_bar, Page));
            this.createRoute('*', '404', false, NotFound)
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
