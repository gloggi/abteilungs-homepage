<template>
    <div id="app" v-if="loaded"
         :style="'--primary-color: '+settings[0].primary_color+';--secondary-color: '+settings[0].secondary_color">
        <Header :page="findPage()" :pages="pages"
                :settings="settings"></Header>
        <Navbar :pages="pages" :routes="routes" :settings="settings"></Navbar>
        <router-view :page="findPage()"
                     :pages="pages"
                     :age_levels="age_levels"
                     :groups="groups"
                     :contacts="contacts"
                     :events="events"
                     :special_events="special_events"
                     :locations="locations"
                     :settings="settings"></router-view>
        <Footer :groups="groups" :settings="settings"></Footer>
    </div>
</template>

<script>
    import page from './components/Page'
    import Header from './components/Header'
    import Navbar from "./components/Navbar";
    import Footer from "./components/Footer";
    import NotFound from "./components/NotFound";

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
                age_levels: [],
                contacts: [],
                events: [],
                groups: [],
                locations: [],
                pages: [],
                settings: [],
                special_events: [],
                routes: [],
                loaded: false,
                loaded_items: {}
            }
        },
        metaInfo() {
            return {
                title: `${this.scoutGroupName} | ${this.findPage().name}`,
                htmlAttrs: {
                    lang: 'de',
                    amp: true
                },
                link: [
                    {rel: 'icon', type: "image/png", href: this.favicon}
                ]
            }
        },
        methods: {
            getItems(item) {
                this.$http.get('items/' + item + '?fields=*.*.*').then(
                    response => {
                        this[item] = response.data.data;
                        this.loaded_items[item]=true
                        this.loaded_check()
                        if (item == 'pages') {
                            this.setRoutes(this.pages);
                        }
                    },
                    error => {
                        console.log(error)
                    }
                )
            },
            loadData() {
                var vm = this;
                this.items.forEach(function (item) {
                    vm.loaded_items[item]=false
                    vm.getItems(item);
                })
            },
            createAndAppendRoute(route, route_name, route_show, component) {
                let newRoute = {
                    path: `/${route}`,
                    component: component,
                    name: `${route_name}`,
                    show: route_show
                }

                this.$router.addRoutes([newRoute])
                this.routes.push(newRoute)
            },
            setRoutes(pages) {
                var vm = this;
                pages.forEach(function (item, index) {
                    if (index == 0) {
                        item.route = ''
                    }
                    vm.createAndAppendRoute(item.route, item.name, item.show_in_navigation_bar, page)
                })
                vm.createAndAppendRoute('*', '404', false, NotFound)
            },
            findPage() {
                var vm = this;
                var page = {};
                this.pages.forEach(function (item) {
                    if (vm.$route.name == item.name) {
                        page = item
                    }

                })
                return page
            },
            loaded_check(){
                var loaded = true
                for(var item in this.loaded_items){
                    if(!this.loaded_items[item]){
                        loaded = false;
                    }
                }
                this.loaded = loaded
            }
        },
        computed: {
            scoutGroupName() {
                if (this.settings.length > 0) {
                    return this.settings[0].scout_group_name
                }
                return "Pfadiabteilung"
            },
            favicon() {
                    if (this.settings.length > 0) {
                        return this.settings[0].favicon.data.full_url
                    }
                    return ""
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
