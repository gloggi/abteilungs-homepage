<template>
  <AlertBar v-if="settings.showAlert" />
  <GroupPage
    :key="`group-${pageKey}`"
    v-if="pageType === 'groupPage'"
    :group="group"
  >
    <template v-slot:navbar>
      <NavBar :menuItems="menuItems" />
    </template>
  </GroupPage>
  <RegularPage
    :key="`page-${pageKey}`"
    v-if="pageType === 'regularPage'"
    :page="page"
  >
    <template v-slot:navbar>
      <NavBar :menuItems="menuItems" />
    </template>
  </RegularPage>
  <FooterComponent v-if="pageType" />
  <CookieBanner />
</template>
<script>
import NavBar from "../components/main/NavBar.vue";
import FooterComponent from "../components/main/FooterComponent.vue";
import RegularPage from "./RegularPage.vue";
import GroupPage from "./GroupPage.vue";
import CookieBanner from "../components/main/CookieBanner.vue";
import AlertBar from "../components/main/AlertBar.vue";

export default {
  components: {
    NavBar,
    FooterComponent,
    RegularPage,
    GroupPage,
    CookieBanner,
    AlertBar,
  },
  data() {
    return {
      page: undefined,
      pageKey: 0,
      menuItems: [],
      pageType: undefined,
      group: undefined,
    };
  },
  methods: {
    async routeHandler() {
      if (this.$route.name == "GroupPage") {
        let groupId = this.$route.params.id;
        await this.getGroup(groupId);
        if (!this.group.enableGroupPage) {
          this.$router.go(-1);
        }
        this.pageType = "groupPage";
      } else {
        let pageRoute = this.$route.path.substring(1);
        if (pageRoute === "") {
          pageRoute = 0;
        }
        await this.getPage(pageRoute);
        this.pageType = "regularPage";
      }
      this.pageKey++;
    },
    async getPage(pageRoute) {
      try {
        const response = await this.callApi("get", `/pages/${pageRoute}`);
        this.page = response.data;
        document.title = `${this.page.title} | ${this.settings.divisionName}`;
      } catch (error) {
        if (this.settings.notFoundPage) {
          return this.getPage(this.settings.notFoundPage.route);
        } else {
          console.log("here");
          return this.getPage(0);
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
    async getGroup(groupId) {
      try {
        const response = await this.callApi("get", `/groups/${groupId}`);
        this.group = response.data;
      } catch (error) {
        //console.log(error);
      }
    },
    handlePageChange(event) {
      console.log(event);
      //this.routeHandler()
    },
  },
  watch: {
    $route() {
      this.routeHandler();
    },
  },
  async created() {
    await this.getMenuItems();
    await this.routeHandler();
  },
};
</script>
<style></style>
