<template>
  <div
    class="rounded-t-full"
    :class="
      showMobileMenu ? 'bg-primary ' : isDesktop ? 'bg-[#808080]' : 'bg-white'
    "
  >
    <nav
      class="relative z-10 md:static bg-primary w-full flex h-[75px] -mt-[75px] px-5 flex-col md:flex-row justify-between items-center text-white rounded-lg"
    >
      <div class="flex justify-between items-center w-full h-full md:w-auto">
        <div class="flex items-center">
          <router-link to="/"
            ><img
              class="h-14"
              :src="`${backendURL}${settings?.divisionLogo?.path}`"
          /></router-link>
        </div>
        <button
          v-if="!isDesktop"
          @click="showMobileMenu = !showMobileMenu"
          class="px-3"
        >
          <font-awesome-icon :icon="icons.faBars" />
        </button>
      </div>
      <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
        <ul
          class="flex flex-col md:flex-row md:space-x-5 w-full md:w-auto absolute z-10 md:static top-[75px] md:top-0 bg-primary h-full md:h-auto"
          v-if="showMobileMenu || isDesktop"
        >
          <template v-for="menuItem in menuItems" :key="menuItem.id">
            <NavLinkItem v-if="!menuItem.special" :menuItem="menuItem">{{
              menuItem.title
            }}</NavLinkItem>
            <GroupDropdown v-else />
          </template>
        </ul>
      </Transition>
    </nav>
  </div>
</template>
<script>
import GroupDropdown from "./GroupDropdown.vue";
import NavLinkItem from "./NavLinkItem.vue";
import { faBars } from "@fortawesome/free-solid-svg-icons";
import { gsap } from "gsap";
export default {
  components: { NavLinkItem, GroupDropdown },
  props: {
    menuItems: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      icons: {
        faBars,
      },
      showMobileMenu: false,
      isDesktop: window.innerWidth > 768,
    };
  },
  methods: {
    beforeEnter(el) {
      el.style.height = "0";
      el.style.overflow = "hidden";
    },
    enter(el, done) {
      gsap.to(el, {
        height: "auto",
        overflow: "visible",
        duration: 0.3,
        onComplete: function () {
          const offsetTop =
            el.getBoundingClientRect().top + window.scrollY - 75;
          window.scrollTo({ top: offsetTop, behavior: "smooth" });
          done();
        },
      });
    },
    leave(el, done) {
      gsap.to(el, { height: "0", duration: 0.3, onComplete: done });
    },
    handleResize() {
      this.isDesktop = window.innerWidth > 768;
    },
  },
  mounted() {
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize);
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
