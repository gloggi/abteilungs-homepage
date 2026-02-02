<template>
  <div>
    <Transition
      enter-active-class="transition-opacity duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <button
        v-if="!isDesktop && !isOpen"
        @click="isOpen = true"
        class="fixed z-50 right-4 top-4 h-10 w-10 flex items-center justify-center rounded-md bg-gray-900/90 text-white shadow-lg border border-gray-700/50 backdrop-blur-sm hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
        aria-label="Open Sidebar"
      >
        <font-awesome-icon :icon="icons.faBars" class="h-5 w-5" />
      </button>
    </Transition>

    <Transition
      enter-active-class="transition-opacity ease-linear duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity ease-linear duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen && !isDesktop"
        class="fixed inset-0 bg-gray-950/80 backdrop-blur-sm z-40 md:hidden"
        @click="isOpen = false"
      ></div>
    </Transition>

    <aside
      class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 border-r border-gray-800 transform transition-transform duration-300 ease-in-out md:static md:translate-x-0 flex flex-col h-full shadow-2xl md:shadow-none"
      :class="[!isOpen && !isDesktop ? '-translate-x-full' : 'translate-x-0']"
    >
      <router-link
        to="/dashboard"
        @click="isOpen = false"
        class="flex-shrink-0 flex flex-col justify-center items-center min-h-[5rem] border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm px-4 pt-6 pb-4"
      >
        <div
          v-if="settings.divisionLogo?.path"
          class="w-full flex justify-center"
        >
          <img
            class="h-28 object-contain p-2 hover:scale-105 transition-transform duration-300"
            :src="`${backendURL}${settings.divisionLogo?.path}`"
            alt="Division Logo"
          />
        </div>
        <div
          v-else-if="settings.divisionName"
          class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-gray-200 via-gray-400 to-gray-600 text-center mx-auto tracking-tight"
        >
          {{ settings.divisionName }}
        </div>
        <div class="w-full flex justify-center items-center py-4" v-else>
          <font-awesome-icon
            class="h-16 text-gray-700 animate-pulse"
            :icon="icons.faGhost"
          />
        </div>
      </router-link>

      <div class="flex-1 overflow-y-auto py-4 custom-scrollbar">
        <nav class="space-y-1 px-1">
          <SidebarItem
            to="/dashboard"
            :icon="icons.faHome"
            @click="isOpen = false"
            :exact="true"
          >
            {{ $t("dashboard.home") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/menu"
            :icon="icons.faEllipsis"
            @click="isOpen = false"
          >
            {{ $t("dashboard.menuAndLinks") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/pages"
            :icon="icons.faBookOpen"
            @click="isOpen = false"
          >
            {{ $t("dashboard.pages") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/groups"
            :icon="icons.faUsers"
            @click="isOpen = false"
          >
            {{
              settings.isRegion
                ? $t("dashboard.divisions")
                : $t("dashboard.groups")
            }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/blogposts"
            :icon="icons.faNewspaper"
            @click="isOpen = false"
          >
            {{ $t("dashboard.blogPosts") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/contacts"
            :icon="icons.faAddressCard"
            @click="isOpen = false"
          >
            {{ $t("dashboard.contacts") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/sections"
            :icon="icons.faStairs"
            @click="isOpen = false"
          >
            {{ $t("dashboard.sections") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/events"
            :icon="icons.faCalendarDays"
            @click="isOpen = false"
          >
            {{ $t("dashboard.events") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/camps"
            :icon="icons.faCampground"
            @click="isOpen = false"
          >
            {{ $t("dashboard.camps") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/locations"
            :icon="icons.faLocationDot"
            @click="isOpen = false"
          >
            {{ $t("dashboard.locations") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/faqs"
            :icon="icons.faCircleQuestion"
            @click="isOpen = false"
          >
            {{ $t("dashboard.faqs") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/forms"
            :icon="icons.faRectangleList"
            @click="isOpen = false"
          >
            {{ $t("dashboard.forms") }}
          </SidebarItem>
          <SidebarItem
            to="/dashboard/media"
            :icon="icons.faPhotoVideo"
            @click="isOpen = false"
          >
            {{ $t("dashboard.media") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/users"
            :icon="icons.faUser"
            @click="isOpen = false"
          >
            {{ $t("dashboard.users") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/settings"
            :icon="icons.faGear"
            @click="isOpen = false"
          >
            {{ $t("dashboard.settings") }}
          </SidebarItem>
          <SidebarItem
            v-if="isAdmin"
            to="/dashboard/tags"
            :icon="icons.faTags"
            @click="isOpen = false"
          >
            {{ $t("dashboard.tags") }}
          </SidebarItem>
        </nav>
      </div>

      <div class="p-4 border-t border-gray-800 bg-gray-900/50">
        <SidebarItem @click="logout" to="" :icon="icons.faDoorOpen">
          {{ $t("dashboard.logout") }}
        </SidebarItem>
      </div>
    </aside>
  </div>
</template>

<script>
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
  faGhost,
  faHome,
  faNewspaper,
  faTags,
} from "@fortawesome/free-solid-svg-icons";
import SidebarItem from "./SidebarItem.vue";

export default {
  components: { SidebarItem },
  data() {
    return {
      isOpen: false,
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
        faGhost,
        faHome,
        faNewspaper,
        faTags,
      },
    };
  },
  methods: {
    logout() {
      this.$store.dispatch("user/logout");
      this.$router.push("/");
    },
    handleResize() {
      this.isDesktop = window.innerWidth > 768;
      if (this.isDesktop) {
        this.isOpen = false;
      }
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

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #374151;
  border-radius: 20px;
}
</style>
