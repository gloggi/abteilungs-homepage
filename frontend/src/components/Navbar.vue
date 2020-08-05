<template>
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button @click="collapseNavbar" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Navigation umschalten</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="navbar__logo" :src="settings.logo.data.full_url" height="50" alt="">
                </a>
            </div>

            <div class="collapse navbar-collapse" :class="collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li  v-for="{ name } in routes" class="dropdown" :key="name">
                        <router-link :to="{ name: name }">{{name}}</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    props: ["pages", "settings"],
    data() {
        return {
            collapse: ''
        }
    },
    methods: {
        collapseNavbar() {
            this.collapse = this.collapse ? '' : 'in'
        }
    },
    computed: {
        routes() {
            return this.pages
                .filter(page => page.show_in_navigation_bar)
                .map(page => ({ name: page.name }))
        }
    }
}
</script>

<style scoped>

</style>