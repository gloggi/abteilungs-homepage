<template>
  <div class="flex flex-no-wrap bg-gray-200 h-full w-full fixed">
    <Sidebar />
    <div class="container mx-auto h-full px-2 md:px-10 overflow-y-scroll">
      <div class="py-6">
        <div class="w-full h-full">
          <router-view> </router-view>
        </div>
      </div>
    </div>
  </div>
  <SuccessMessage />
</template>

<script>
import Sidebar from "../components/admin/Sidebar.vue";
import SuccessMessage from "../components/admin/SuccessNotification.vue";
export default {
  components: { Sidebar, SuccessMessage },
  computed: {
    user() {
      return this.$store.state.user.user;
    },
  },
  async created() {
    await this.$store.dispatch("settings/getSettings");
    await this.$store.dispatch("user/getUser");
    if (!(this.isAdmin || this.isUnitLeader)) {
      this.$router.push("/login");
      this.notifyUser(
        "Deine Rollen erlauben dir den Zugriff nicht. Wende dich an die Abteilungsleitung.",
        true,
      );
    }
  },
};
</script>

<style></style>
