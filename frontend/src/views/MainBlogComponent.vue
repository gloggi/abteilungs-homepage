<template>
  <AlertBar v-if="settings && settings.showAlert" />
  <UserBar v-if="showUserBar" :blogPostId="currentPost?.id" />

  <RegularPage v-if="shouldShowSinglePost" :page="formattedPostForBuilder">
    <template #navbar>
      <NavBar :menuItems="menuItems" :alertVisible="alertVisible" />
    </template>
  </RegularPage>

  <div v-else>
    <div v-if="isNavbarTop">
      <NavBar :menuItems="menuItems" :alertVisible="alertVisible" />
    </div>

    <SmallHeader :title="$t('blog.title')" :images="[]" />

    <div v-if="!isNavbarTop">
      <NavBar :menuItems="menuItems" :alertVisible="alertVisible" />
    </div>

    <PageWrapper>
      <ContentWrapper>
        <BlogList :limit="6" />
      </ContentWrapper>
    </PageWrapper>
  </div>

  <FooterComponent />
  <CookieBanner />
</template>

<script>
import AlertBar from "../components/main/AlertBar.vue";
import BlogList from "../components/main/BlogList.vue";
import ContentWrapper from "../components/main/ContentWrapper.vue";
import CookieBanner from "../components/main/CookieBanner.vue";
import FooterComponent from "../components/main/FooterComponent.vue";
import NavBar from "../components/main/NavBar.vue";
import PageBuilder from "../components/main/PageBuilder.vue";
import PageWrapper from "../components/main/PageWrapper.vue";
import RegularPage from "./RegularPage.vue";
import SmallHeader from "../components/main/SmallHeader.vue";
import UserBar from "../components/main/UserBar.vue";

export default {
  name: "BlogContainer",

  components: {
    AlertBar,
    BlogList,
    CookieBanner,
    ContentWrapper,
    FooterComponent,
    NavBar,
    PageBuilder,
    PageWrapper,
    RegularPage,
    SmallHeader,
    UserBar,
  },

  data() {
    return {
      currentPost: null,
      menuItems: [],
      alertVisible: false,
      isLoading: false,
    };
  },

  computed: {
    postSlug() {
      return this.$route.params.slug;
    },

    shouldShowSinglePost() {
      return !!this.postSlug && !!this.currentPost;
    },

    formattedPostForBuilder() {
      return this.formattedPost;
    },
    formattedPost() {
      if (!this.currentPost) return null;

      const { pageItems, page_items, files, ...rest } = this.currentPost;
      return {
        ...rest,
        pageItems: pageItems ?? page_items ?? [],
        files: files ?? [],
        bigHeader: false,
      };
    },

    showUserBar() {
      const auth = this.$store.state.user;
      if (!auth?.user) return false;

      return Boolean(auth.isAdmin || auth.isUnitLeader);
    },

    settings() {
      return this.$store.state.settings;
    },
  },

  watch: {
    postSlug: {
      handler: "syncDataSource",
      immediate: true,
    },
  },

  mounted() {
    this.prepareComponent();
  },

  methods: {
    async prepareComponent() {
      await this.fetchMenuItems();
      this.evaluateAlertStatus();
    },

    async syncDataSource() {
      this.isLoading = true;
      try {
        if (this.postSlug) {
          await this.getPostBySlug(this.postSlug);
        } else {
          this.currentPost = null;
        }
      } finally {
        this.isLoading = false;
      }
    },

    async getPostBySlug(slug) {
      const { data } = await this.callApi("get", `/blogposts/${slug}`);
      this.currentPost = data;
    },

    async fetchMenuItems() {
      const { data } = await this.callApi("get", "/menuitems");
      this.menuItems = data.data || [];
    },
    evaluateAlertStatus() {
      const { showAlert, alertText } = this.settings || {};
      const isDismissed = localStorage.getItem("alert") === alertText;
      this.alertVisible = !!(showAlert && !isDismissed);
    },
  },
};
</script>
