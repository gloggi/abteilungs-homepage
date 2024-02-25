<template>
  <div class="absolute bottom-0 top-0 md:static z-30">
    <div class="-right-16 absolute size-16 bottom-0 md:hidden">
      <button
        @click="hideMobileMenu = !hideMobileMenu"
        class="size-12 bg-gray-900 rounded-r-lg"
      >
        <font-awesome-icon :icon="icons.faBars" class="text-white" />
      </button>
    </div>
    <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
      <div
        v-if="!(hideMobileMenu && !isDesktop)"
        class="bg-gray-900 md:w-64 md:flex flex-col md:rounded-r-lg h-full"
      >
        <router-link to="/dashboard">
          <div
            v-if="settings.divisionLogo?.path"
            class="w-full flex flex-col justify-center"
          >
            <img
              class="h-32 p-3"
              :src="`${backendURL}/${settings.divisionLogo?.path}`"
            />
          </div>
          <div
            v-else
            class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 text-center mx-auto p-5 cursor-pointer"
          >
            {{ settings.divisionName || "Abteilungshomepage" }}
          </div>
        </router-link>
        <div class="flex flex-col md:justify-between h-full">
          <div>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/menu"
              :icon="icons.faEllipsis"
            >
              {{ $t("dashboard.menuAndLinks") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/pages"
              :icon="icons.faBookOpen"
            >
              {{ $t("dashboard.pages") }}
            </SidebarItem>
            <SidebarItem to="/dashboard/groups" :icon="icons.faUsers">
              {{ $t("dashboard.groups") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/contacts"
              :icon="icons.faAddressCard"
            >
              {{ $t("dashboard.contacts") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/sections"
              :icon="icons.faStairs"
            >
              {{ $t("dashboard.sections") }}
            </SidebarItem>
            <SidebarItem to="/dashboard/events" :icon="icons.faCalendarDays">
              {{ $t("dashboard.events") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/camps"
              :icon="icons.faCampground"
            >
              {{ $t("dashboard.camps") }}
            </SidebarItem>
            <SidebarItem to="/dashboard/locations" :icon="icons.faLocationDot">
              {{ $t("dashboard.locations") }}
            </SidebarItem>
            <SidebarItem to="/dashboard/faqs" :icon="icons.faCircleQuestion">
              {{ $t("dashboard.faqs") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/forms"
              :icon="icons.faRectangleList"
            >
              {{ $t("dashboard.forms") }}
            </SidebarItem>
            <SidebarItem to="/dashboard/media" :icon="icons.faPhotoVideo">
              {{ $t("dashboard.media") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/users"
              :icon="icons.faUser"
            >
              {{ $t("dashboard.users") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/settings"
              :icon="icons.faGear"
            >
              {{ $t("dashboard.settings") }}
            </SidebarItem>
          </div>
          <div class="h-fit">
            <SidebarItem
              @click="logout"
              class=""
              to=""
              :icon="icons.faDoorOpen"
            >
              {{ $t("dashboard.logout") }}
            </SidebarItem>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { gsap } from "gsap";
import {
  faStairs,
  faBookOpen,
  faPhotoVideo,
  faUsers,
  faUser,
  faRectangleList,
  faEllipsis,
  faGear,
  faLocationDot,
  faCalendarDays,
  faAddressCard,
  faCampground,
  faDoorOpen,
  faCircleQuestion,
  faBars,
} from "@fortawesome/free-solid-svg-icons";
import SidebarItem from "./SidebarItem.vue";
export default {
  components: { SidebarItem },
  data() {
    return {
      hideMobileMenu: true,
      isDesktop: window.innerWidth > 768,
      icons: {
        faStairs,
        faBookOpen,
        faPhotoVideo,
        faUsers,
        faUser,
        faRectangleList,
        faEllipsis,
        faGear,
        faLocationDot,
        faCalendarDays,
        faAddressCard,
        faCampground,
        faDoorOpen,
        faCircleQuestion,
        faBars,
      },
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.$router.push("/");
    },
    beforeEnter(el) {
      el.style.width = "0";
      el.style.overflow = "hidden";
    },
    enter(el, done) {
      gsap.to(el, {
        width: "auto",
        overflow: "hidden",
        whiteSpace: "nowrap",
        breakAfter: "avoid",
        duration: 0.3,
        onComplete: done,
      });
    },
    leave(el, done) {
      gsap.to(el, { width: "0", duration: 0.3, onComplete: done });
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

<style></style>
