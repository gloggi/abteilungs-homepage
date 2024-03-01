<template>
  <div :class="isDesktop ? 'bg-[#808080]' : 'bg-white'">
    <div
      class="flex justify-center w-full background bg-[#4A4A4A] rounded-t-lg"
    >
      <div
        class="md:w-[900px] flex flex-col md:flex-row items-start w-full px-5 md:px-0 md:justify-between py-6 md:space-y-0 space-y-10"
      >
        <div>
          <h2 class="text-heading-2 text-primary text-4xl">
            {{ $t("page.groupsTitle") }}
          </h2>
          <ul class="text-white text-xl main-text space-y-1 pt-5">
            <template v-for="group in transformedGroups" :key="group.id">
              <li v-if="!group.parentId" class="pl-6">
                <router-link
                  :to="group.hasPage ? `/group/${group.route}` : '#'"
                  >{{ group.name }}</router-link
                >
                <ul
                  v-if="group.children.length > 0"
                  class="text-white text-xl main-text space-y-1"
                >
                  <li
                    v-for="child in group.children"
                    :key="child.id"
                    class="pl-6"
                  >
                    <router-link
                      :to="
                        child.hasPage ? `/group/${child.route}` : '#'
                      "
                      >{{ child.name }}</router-link
                    >
                  </li>
                </ul>
              </li>
            </template>
          </ul>
        </div>
        <div>
          <h2 class="text-heading-2 text-primary text-4xl">
            {{ $t("page.linksTitle") }}
          </h2>
          <ul class="text-white text-xl main-text space-y-1 pt-5 pl-6">
            <li v-for="link in footerLinks" :key="link.id">
              <a :href="link.url" target="_blank">{{ link.title }}</a>
            </li>
            <li>
              <router-link :to="{ name: 'Login' }">{{
                $t("page.login")
              }}</router-link>
            </li>
          </ul>
        </div>
        <div>
          <h2 class="text-heading-2 text-primary text-4xl">
            {{ $t("page.contactTitle") }}
          </h2>
          <div
            class="text-white pl-6 pt-5" 
            v-html="formatFooterText(settings?.contactInFooter)"
            v-router-link
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      footerLinks: [],
      isDesktop: window.innerWidth > 768,
    };
  },
  methods: {
    async getGroups() {
      this.$store.dispatch("groups/fetchGroups");
    },
    async getFooterLinks() {
      try {
        const response = await this.callApi("get", "/footerlinks");
        this.footerLinks = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    formatFooterText(text) {
      return text.replace("main-text", "main-text text-xl text-white");
    },
  },
  computed: {
    transformedGroups() {
      return this.groups.map((group) => ({
        ...group,
        children: this.groups.filter((g) => g.parentId === group.id),
      }));
    },
    groups() {
      return this.$store.state.groups.groups;
    },
  },
  async created() {
    this.getGroups();
    await this.getFooterLinks();
  },
};
</script>
