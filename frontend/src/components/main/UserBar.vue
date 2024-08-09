<template>
  <div
    class="fixed z-50 w-full h-8 bg-gray-900 text-white mb-5 hidden md:flex flex-row justify-between px-5"
  >
    <div class="flex flex-row space-x-2 items-center">
      <img class="py-1 h-full" :src="logo" />
      <div class="flex flex-row space-x-5 items-center pl-5">
        <button @click="goToDashboard">
          <font-awesome-icon :icon="icons.faGauge" />
          {{ $t("dashboard.goToDashboard") }}
        </button>
        <button @click="goToEditPage" v-if="showPageEdit">
          <font-awesome-icon :icon="icons.faPen" />
          {{ $t("dashboard.editPage") }}
        </button>
        <button @click="goToEvents" v-if="showActivityEdit">
          <font-awesome-icon :icon="icons.faCalendarDays" />
          {{ $t("dashboard.editEvents") }}
        </button>
      </div>
    </div>
    <div class="flex flex-row space-x-5 items-center">
      <button>
        <font-awesome-icon :icon="icons.faUser" />
        {{ userName }}
      </button>
      <button @click="logout">
        <font-awesome-icon :icon="icons.faDoorOpen" />
        {{ $t("dashboard.logout") }}
      </button>
    </div>
  </div>
</template>
<script>
import {
  faDoorOpen,
  faPen,
  faGauge,
  faUser,
  faCalendarDays,
} from "@fortawesome/free-solid-svg-icons";
export default {
  data() {
    return {
      show: false,
      icons: {
        faDoorOpen,
        faPen,
        faGauge,
        faUser,
        faCalendarDays,
      },
    };
  },
  props: ["pageId", "groupId"],
  methods: {
    goToEditPage() {
      this.$router.push(`/dashboard/pages/${this.pageId}`);
    },
    goToDashboard() {
      this.$router.push("/dashboard");
    },
    goToEvents() {
      this.$router.push(`/dashboard/events`);
    },
    logout() {
      this.$store.dispatch("user/logout");
    },
  },
  computed: {
    userName() {
      return this.$store.state.user.user.nickname;
    },
    logo() {
      return this.backendURL + this.settings.divisionLogo?.path;
    },
    showPageEdit() {
      return (
        this.$store.state.user.groupIds.includes(this.groupId) || this.isAdmin
      );
    },
    showActivityEdit() {
      return (
        this.groupId &&
        (this.$store.state.user.groupIds.includes(this.groupId) || this.isAdmin)
      );
    },
  },
};
</script>
