
<template>
    
    <nav class="relative md:static bg-primary w-full flex h-[75px] -mt-[75px] px-5 flex-col md:flex-row justify-between items-center text-white">
        <div class="flex justify-between items-center w-full h-full md:w-auto">
            <div class="flex items-center"><router-link to="/"><img class="h-14" :src="`${backendURL}${settings?.divisionLogo?.path}`" /></router-link></div>
            <button v-if="!isDesktop" @click="showMobileMenu = !showMobileMenu" class="px-3"><font-awesome-icon :icon="icons.faBars" /></button>
        </div>
        <Transition name="menu-fade">
            <ul if="togglemenu" class="flex flex-col md:flex-row md:space-x-5 w-full md:w-auto absolute z-10 md:static top-[75px] md:top-0 bg-primary" v-if="showMobileMenu || isDesktop">
                <NavLinkItem v-for="menuItem in menuItems" :menuItem="menuItem" :key="menuItem.id" @pageChange="e=>$emit('pageChange',e)">{{ menuItem.title }}</NavLinkItem>

            </ul>
        </Transition>

    </nav>

</template>
<script>
import NavLinkItem from './NavLinkItem.vue';
import { faBars } from "@fortawesome/free-solid-svg-icons";

export default {
    components: { NavLinkItem },
    emits: ['pageChange'],
    props: {
        menuItems: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            icons: {
                faBars
            },
            showMobileMenu: false,
            isDesktop: window.innerWidth > 768
        }
    },
    methods: {
        handleResize() {
            this.isDesktop = window.innerWidth > 768;
        },
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.handleResize);
    },
};
</script>
<style>
.menu-fade-enter-from,
.menu-fade-leave-to {
    opacity: 0;
}

.menu-fade-enter-to,
.menu-fade-leave-from {
    opacity: 1;
}

.menu-fade-enter-active,
.menu-fade-leave-active {
    transition: opacity 0.5s ease;
}
</style>