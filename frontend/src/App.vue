<template>
    <div id="app"
         :style="'--primary-color: '+settings[0].primary_color+';--secondary-color: '+settings[0].secondary_color">
        <Header :page="findPage()" :pages="pages"
                :settings="settings"></Header>
        <Navbar :pages="pages" :routes="routes" :settings="settings"></Navbar>
        <router-view :page="findPage()"
                     :pages="pages"
                     :age_levels="age_levels"
                     :groups="groups"></router-view>
        <Footer :groups="groups" :settings="settings"></Footer>
    </div>
</template>

<script>
    import page from './components/Page'
    import Header from './components/Header'
    import Navbar from "./components/Navbar";
    import Footer from "./components/Footer";

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
                routes: []
            }
        },
        methods: {
            getItems(item) {
                this.$http.get('items/' + item + '?fields=*.*.*').then(
                    response => {
                        this[item] = response.data.data;
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
                    vm.getItems(item);
                })
            },
            createAndAppendRoute(route, route_name) {
                let newRoute = {
                    path: `/${route}`,
                    component: page,
                    name: `${route_name}`,
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
                    vm.createAndAppendRoute(item.route, item.name)
                })
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
        color: < var(--primary-color) !important;
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
