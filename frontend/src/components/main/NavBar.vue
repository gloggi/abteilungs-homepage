
<template>
    
    <nav class="relative z-10 md:static bg-primary w-full flex h-[75px] -mt-[75px] px-5 flex-col md:flex-row justify-between items-center text-white">
        <div class="flex justify-between items-center w-full h-full md:w-auto">
            <div class="flex items-center"><router-link to="/"><img class="h-14" :src="`${backendURL}${settings?.divisionLogo?.path}`" /></router-link></div>
            <button v-if="!isDesktop" @click="showMobileMenu = !showMobileMenu" class="px-3"><font-awesome-icon :icon="icons.faBars" /></button>
        </div>
        <Transition 
        @beforeEnter="beforeEnter"
        @enter="enter"
        @leave="leave"
        >
            <ul class="flex flex-col md:flex-row md:space-x-5 w-full md:w-auto absolute z-10 md:static top-[75px] md:top-0 bg-primary" v-if="showMobileMenu || isDesktop">
                <template v-for="menuItem in menuItems" :key="menuItem.id">
                    <NavLinkItem v-if="!menuItem.special"  :menuItem="menuItem"  @pageChange="handlePageChange">{{ menuItem.title }}</NavLinkItem>
                    <GroupDropdown v-else />
                </template>
               

            </ul>
        </Transition>

    </nav>

</template>
<script>
import GroupDropdown from './GroupDropdown.vue';
import NavLinkItem from './NavLinkItem.vue';
import { faBars } from "@fortawesome/free-solid-svg-icons";
import { gsap } from 'gsap'
export default {
    components: { NavLinkItem, GroupDropdown },
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
        beforeEnter(el) {
            el.style.transform = "scaleY(0)"
            el.style.transformOrigin = "top"
        },
        enter(el, done) {
            gsap.to(el, { transform: "scaleY(1)", duration: 0.3, onComplete: done })
        },
        leave(el, done) {
            gsap.to(el, { transform: "scaleY(0)", duration: 0.3, onComplete: done })
        },
        handleResize() {
            this.isDesktop = window.innerWidth > 768;
        },
        handlePageChange(e) {
            this.$emit('pageChange',e)
            this.showMobileMenu = false;
        }
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