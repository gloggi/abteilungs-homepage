<template>
  <AlertBar v-if="settings.showAlert" />
  <UserBar v-if="showUserBar" :pageId="page.id" :groupId="page.groupId" />
  <RegularPage
    :key="`page-${pageKey}`"
    v-if="page && !pageNonExistent"
    :page="page"
  >
    <template v-slot:navbar>
      <NavBar :menuItems="menuItems" />
    </template>
  </RegularPage>
  <FooterComponent v-if="page && !pageNonExistent" />
  <CookieBanner />
</template>
<script>
import NavBar from "../components/main/NavBar.vue";
import FooterComponent from "../components/main/FooterComponent.vue";
import RegularPage from "./RegularPage.vue";
import CookieBanner from "../components/main/CookieBanner.vue";
import AlertBar from "../components/main/AlertBar.vue";
import UserBar from "../components/main/UserBar.vue";

export default {
  components: {
    NavBar,
    FooterComponent,
    RegularPage,
    CookieBanner,
    AlertBar,
    UserBar,
  },
  data() {
    return {
      page: undefined,
      pageKey: 0,
      menuItems: [],
      group: undefined,
      pageNonExistent: false,
    };
  },
  methods: {
    async routeHandler() {
      let pageRoute = undefined;
      if (this.$route.name == "GroupPage") {
        pageRoute = this.$route.path.split(
          `/${this.$t("page.groupPagePath")}/`,
        )[1];
      } else {
        pageRoute = this.$route.path.substring(1);
        if (pageRoute === "") {
          pageRoute = 0;
        }
      }
      await this.getPage(pageRoute);
      this.group = undefined;
      this.pageKey++;
    },
    async getPage(pageRoute) {
      const token = localStorage.getItem(pageRoute);
      try {
        const response = await this.callApi(
          "get",
          `/pages/${pageRoute}`,
          {},
          { params: { token } },
        );
        this.page = response.data;
      } catch (error) {
        if (this.settings.notFoundPage) {
          return this.getPage(this.settings.notFoundPage.route);
        } else if (pageRoute !== 0) {
          return this.getPage(0);
        } else {
          this.pageNonExistent = true;
        }
      }
    },
    async getMenuItems() {
      try {
        const response = await this.callApi("get", "/menuitems");
        this.menuItems = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    handlePageChange(event) {
      console.log(event);
    },
  },
  computed: {
    metaTitle() {
      return `${this.page?.title || this.group?.page?.title || ""} | ${
        this.settings?.divisionName || ""
      }`;
    },
    showUserBar() {
      const user = this.$store.state.user;
      return this.$store.state.user.user && (user.isAdmin || user.isUnitLeader);
    },
  },
  watch: {
    $route() {
      this.routeHandler();
    },
    metaTitle() {
      document.title = this.metaTitle;
    },
  },
  async created() {
    await this.getMenuItems();
    await this.routeHandler();
  },
};
</script>
<style></style>
