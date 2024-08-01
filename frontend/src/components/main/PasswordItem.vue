<template>
  <ContentWrapper>
    <HeadingTwo class="text-primary"
      >Diese Seite ist Passwortgeschützt!</HeadingTwo
    >
    <p class="main-text">
      Bitte gib das Passwort ein, um Zugriff auf diese Seite zu erhalten.
    </p>
    <form @submit.prevent="getPageToken" class="flex flex-col space-y-2 pt-2">
      <input
        v-model="password"
        autocomplete="off"
        class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary w-full"
        type="password"
        placeholder="Passwort"
      />
      <p v-if="error" class="text-primary">{{ $t("page.wrongPassword") }}</p>
      <BasicButton class="w-full" type="submit">{{
        $t("page.openProtectedPage")
      }}</BasicButton>
    </form>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingTwo from "./HeadingTwo.vue";
import BasicButton from "./BasicButton.vue";
export default {
  data() {
    return {
      password: undefined,
      error: false,
    };
  },
  props: ["route"],
  methods: {
    async getPageToken() {
      try {
        const response = await this.callApi("post", "/pages/token", {
          password: this.password,
          route: this.route || "",
        });
        if (response.status === 200) {
          localStorage.setItem(this.route || "0", response.data.token);
          this.$router.go();
        }
      } catch (e) {
        this.password = "";
        this.error = true;
      }
    },
  },
  async created() {},
  components: {
    ContentWrapper,
    HeadingTwo,
    BasicButton,
  },
};
</script>
