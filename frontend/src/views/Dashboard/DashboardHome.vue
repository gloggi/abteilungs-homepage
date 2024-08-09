<template>
  <Card v-if="user" class="text-4xl font-extrabold">{{
    $t("dashboard.hello", { name: user.nickname })
  }}</Card>
  <div class="flex flex-col space-y-2 pt-5">
    <template v-for="card in cards" :key="card.id">
      <button
        @click="redirectTo(card.link)"
        v-if="(isAdmin && card.adminOnly) || !card.adminOnly"
        class="bg-gray-50 hover:text-gray-700 rounded-lg px-4 py-2 md:px-5"
      >
        <div class="w-full h-full flex items-center space-x-8">
          <div class="h-full aspect-square">
            <font-awesome-icon :icon="card.icon" class="size-10" />
          </div>
          <p class="font-semibold text-xl">{{ card.name }}</p>
        </div>
      </button>
    </template>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
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
} from "@fortawesome/free-solid-svg-icons";
export default {
  components: { Card },
  data() {
    return {
      cards: [
        {
          id: 1,
          name: this.$t("dashboard.menuAndLinks"),
          adminOnly: true,
          icon: faEllipsis,
          link: "/dashboard/menu",
        },
        {
          id: 2,
          name: this.$t("dashboard.pages"),
          adminOnly: false,
          icon: faBookOpen,
          link: "/dashboard/pages",
        },
        {
          id: 3,
          name: this.isRegion
            ? this.$t("dashboard.divisions")
            : this.$t("dashboard.groups"),
          adminOnly: false,
          icon: faUsers,
          link: "/dashboard/groups",
        },
        {
          id: 4,
          name: this.$t("dashboard.contacts"),
          adminOnly: true,
          icon: faAddressCard,
          link: "/dashboard/contacts",
        },
        {
          id: 5,
          name: this.$t("dashboard.sections"),
          adminOnly: true,
          icon: faStairs,
          link: "/dashboard/sections",
        },
        {
          id: 6,
          name: this.$t("dashboard.events"),
          adminOnly: false,
          icon: faCalendarDays,
          link: "/dashboard/events",
        },
        {
          id: 7,
          name: this.$t("dashboard.camps"),
          adminOnly: false,
          icon: faCampground,
          link: "/dashboard/camps",
        },
        {
          id: 8,
          name: this.$t("dashboard.locations"),
          adminOnly: false,
          icon: faLocationDot,
          link: "/dashboard/locations",
        },
        {
          id: 9,
          name: this.$t("dashboard.faqs"),
          adminOnly: false,
          icon: faCircleQuestion,
          link: "/dashboard/faqs",
        },
        {
          id: 10,
          name: this.$t("dashboard.forms"),
          adminOnly: false,
          icon: faRectangleList,
          link: "/dashboard/forms",
        },
        {
          id: 11,
          name: this.$t("dashboard.media"),
          adminOnly: false,
          icon: faPhotoVideo,
          link: "/dashboard/media",
        },
        {
          id: 12,
          name: this.$t("dashboard.users"),
          adminOnly: true,
          icon: faUser,
          link: "/dashboard/users",
        },
        {
          id: 13,
          name: this.$t("dashboard.settings"),
          adminOnly: true,
          icon: faGear,
          link: "/dashboard/settings",
        },
      ],
    };
  },
  computed: {
    user() {
      return this.$store.state.user.user;
    },
    isRegion() {
      return this.settings.isRegion;
    },
  },
  methods: {
    redirectTo(link) {
      this.$router.push(link);
    },
  },
};
</script>

<style></style>
