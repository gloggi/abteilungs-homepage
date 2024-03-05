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
        <router-link to="/dashboard" @click="hideMobileMenu = true">
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
            v-else-if="settings.divisionName"
            class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 text-center mx-auto p-5 cursor-pointer"
          >
            {{ settings.divisionName }}
          </div>
          <div class="w-full flex justify-center items-center" v-else>
            <font-awesome-icon
              class="h-20 py-5 text-white"
              :icon="icons.faGhost"/>
          </div>
          
        </router-link>
        <div class="flex flex-col md:justify-between h-full">
          <div>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/menu"
              :icon="icons.faEllipsis"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.menuAndLinks") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/pages"
              :icon="icons.faBookOpen"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.pages") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/groups"
              :icon="icons.faUsers"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.groups") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/contacts"
              :icon="icons.faAddressCard"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.contacts") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/sections"
              :icon="icons.faStairs"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.sections") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/events"
              :icon="icons.faCalendarDays"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.events") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/camps"
              :icon="icons.faCampground"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.camps") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/locations"
              :icon="icons.faLocationDot"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.locations") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/faqs"
              :icon="icons.faCircleQuestion"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.faqs") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/forms"
              :icon="icons.faRectangleList"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.forms") }}
            </SidebarItem>
            <SidebarItem
              to="/dashboard/media"
              :icon="icons.faPhotoVideo"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.media") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/users"
              :icon="icons.faUser"
              @click="hideMobileMenu = true"
            >
              {{ $t("dashboard.users") }}
            </SidebarItem>
            <SidebarItem
              v-if="isAdmin"
              to="/dashboard/settings"
              :icon="icons.faGear"
              @click="hideMobileMenu = true"
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
  faGhost
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
        faGhost
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
