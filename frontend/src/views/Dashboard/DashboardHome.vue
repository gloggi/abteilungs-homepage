<template>
  <div class="space-y-8">
    <div class="flex items-center justify-between space-y-2">
      <h2 class="text-3xl font-bold tracking-tight" v-if="user">
        {{ $t("dashboard.hello", { name: user.nickname }) }}
      </h2>
    </div>


    <div class="hidden md:grid gap-4 md:grid-cols-2 lg:grid-cols-4">
      <Card v-for="(stat, key) in statsDisplay" :key="key">
        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
          <h3 class="tracking-tight text-sm font-medium text-gray-500">
            {{ stat.label }}
          </h3>
          <font-awesome-icon :icon="stat.icon" class="h-4 w-4 text-gray-500" />
        </div>
        <div class="text-2xl font-bold">{{ stat.value }}</div>
        <p class="text-xs text-gray-500 mt-1" v-if="stat.desc">
          {{ stat.desc }}
        </p>
      </Card>
    </div>

    <div class="border-t border-gray-200"></div>


    <div>
      <h3 class="text-lg font-medium text-gray-900 mb-4">
        {{ $t("dashboard.menuAndLinks") }}
      </h3>
      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="card in filteredCards"
          :key="card.id"
          @click="redirectTo(card.link)"
          class="group rounded-xl border border-gray-200 bg-white text-gray-950 shadow-sm transition-all hover:bg-gray-50 hover:shadow-md cursor-pointer"
        >
          <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex items-center gap-4">
              <div
                class="flex items-center justify-center w-12 h-12 rounded-lg bg-gray-100 group-hover:bg-white transition-colors text-gray-700"
              >
                <font-awesome-icon :icon="card.icon" class="h-6 w-6" />
              </div>
              <div class="space-y-1">
                <h3 class="font-semibold leading-none tracking-tight">
                  {{ card.name }}
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
  faCircleQuestion,
} from "@fortawesome/free-solid-svg-icons";

export default {
  components: { Card },
  data() {
    return {
      stats: {
        pages: 0,
        users: 0,
        groups: 0,
        events: 0,
        camps: 0,
        locations: 0,
      },
    };
  },
  computed: {
    cards() {
      return [
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
      ];
    },
    user() {
      return this.$store.state.user.user;
    },

    isRegion() {
        return this.settings && this.settings.isRegion;
    },
    filteredCards() {

      return this.cards.filter(card => (this.isAdmin && card.adminOnly) || !card.adminOnly);
    },
    statsDisplay() {
      return [
        { label: this.$t("dashboard.pages"), value: this.stats.pages, icon: faBookOpen },
        { label: this.$t("dashboard.users"), value: this.stats.users, icon: faUser },

        { label: this.$t("dashboard.events"), value: this.stats.events, icon: faCalendarDays },
        { label: this.$t("dashboard.camps"), value: this.stats.camps, icon: faCampground },
      ];
    }
  },
  methods: {
    redirectTo(link) {
      this.$router.push(link);
    },
    async fetchStats() {
      try {
        const response = await this.callApi("get", "/dashboard");
        if (response && response.data) {
            this.stats = response.data;
        }
      } catch (error) {
        console.error("Failed to fetch dashboard stats", error);
      }
    }
  },
  mounted() {
    this.fetchStats();
  }
};
</script>

<style></style>
