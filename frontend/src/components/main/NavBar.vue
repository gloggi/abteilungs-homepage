<template>
  <div
    :class="{
      'bg-primary': showMobileMenu,
      'bg-side': !showMobileMenu && isDesktop,
      'bg-white': !showMobileMenu && !isDesktop,
      'pt-8': showUserBar && settings.navbarPosition === 'top',
    }"
  >
    <nav
      class="relative z-10 md:static bg-primary w-full flex h-[75px] px-5 flex-col md:flex-row justify-between items-center text-white rounded-lg"
      :class="{ '-mt-[75px]': !(settings.navbarPosition == 'top') }"
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
          class="flex flex-col md:flex-row md:items-center md:space-x-5 w-full md:w-auto absolute z-10 md:static top-[75px] md:top-0 bg-primary h-full md:h-auto"
          v-if="showMobileMenu || isDesktop"
        >
          <template v-for="menuItem in processedMenuItems" :key="menuItem.id">
            <NavBarItem :menuItem="menuItem" />
          </template>
        </ul>
      </Transition>
    </nav>
  </div>
</template>
<script>
import NavBarItem from "./NavBarItem.vue";
import { faBars } from "@fortawesome/free-solid-svg-icons";
import { gsap } from "gsap";
export default {
  components: { NavBarItem },
  props: {
    menuItems: {
      type: Array,
      required: true,
    },
  },
  computed: {
    showUserBar() {
      const user = this.$store.state.user;
      return this.$store.state.user.user && (user.isAdmin || user.isUnitLeader);
    },
    alertVisible() {
      return this.settings.showAlert;
    },
    groups() {
      return this.$store.state.groups.groups;
    },
    processedMenuItems() {
      return this.menuItems.map((item) => {
        if (item.special === "groupPages") {
          const groupChildren = this.groups
            .filter((g) => g.hasPage)
            .map((g) => ({
              id: `group-${g.id}`,
              title: g.name,
              url: `/${this.$t("page.groupPagePath")}/${g.route}`,
            }));

          return {
            ...item,
            title: this.$t("page.groups"),
            children: groupChildren,
          };
        }
        return item;
      });
    },
  },
  created() {
    this.$store.dispatch("groups/fetchGroups");
  },
  data() {
    return {
      icons: {
        faBars,
      },
      showMobileMenu: false,
      isDesktop: window.innerWidth >= 768,
    };
  },
  mounted() {
    window.addEventListener("resize", this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.handleResize);
  },
  methods: {
    beforeEnter(el) {
      el.style.height = "0";
      el.style.overflow = "hidden";
      el.style.opacity = "0";
    },
    enter(el, done) {
      gsap.to(el, {
        height: "auto",
        opacity: 1,
        duration: 0.3,
        onComplete: function () {
          el.style.overflow = "visible";
          const offsetTop =
            el.getBoundingClientRect().top + window.scrollY - 75;
          window.scrollTo({ top: offsetTop, behavior: "smooth" });
          done();
        },
      });
    },
    leave(el, done) {
      el.style.overflow = "hidden";
      gsap.to(el, { height: "0", opacity: 0, duration: 0.3, onComplete: done });
    },
    handleResize() {
      this.isDesktop = window.innerWidth >= 768;
    },
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
