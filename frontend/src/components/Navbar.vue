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
                    <img class="navbar__logo" :src="settings[0].logo.data.full_url" height="50" alt="">
                </a>
            </div>

            <div class="collapse navbar-collapse" :class="collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <template v-for="route in routes">
                    <li  v-if="route.show" class="dropdown" :key="route.name">
                        <a :href="route.path">{{route.name}}</a>
                    </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        props: ["pages", "routes", "settings"],
        data() {
            return {
                collapse: ""
            }
        },
        methods: {
            collapseNavbar() {
                if (!this.collapse) {
                    this.collapse = "in"
                } else {
                    this.collapse = ""
                }
            }
        }
    }
</script>

<style scoped>

</style>