<template>
  <ContentWrapper>
    <HeadingTwo class="w-full text-primary">{{
      $t("page.contact")
    }}</HeadingTwo>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
      <div
        v-for="contact in contacts"
        :key="contact.id"
        class="flex flex-col items-center text-center gap-3"
      >
        <img
          v-if="contact.file?.path"
          :src="backendURL + contact.file.path"
          class="w-24 h-24 object-cover rounded-full shrink-0"
        />
        <div
          v-else
          class="w-24 h-24 rounded-full shrink-0 bg-gray-200 flex items-center justify-center text-gray-500 font-semibold text-3xl uppercase"
        >
        </div>
        <div class="flex flex-col min-w-0 w-full main-text">
          <p class="text-primary truncate">
            {{ contact.role }}
          </p>
          <p class="truncate font-semibold text-sm">
            {{ contact.firstname }} {{ contact.lastname }}
            {{ contact.nickname ? "v/o" : "" }} {{ contact.nickname }}
          </p>
          <a
            v-if="contact.email"
            class="link hover:text-secondary truncate text-sm"
            :href="`mailto:${contact.email}`"
            :title="contact.email"
            >{{ contact.email }}</a
          >
        </div>
      </div>
    </div>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingThree from "./HeadingThree.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["item"],
  data() {
    return {
      contacts: [],
    };
  },
  methods: {
    async getContacts() {
      try {
        const params = { perPage: 100 };
        if (this.item && this.item.groups && this.item.groups.length > 0) {
          params.group_ids = this.item.groups.map((g) => g.id);
        }
        const response = await this.callApi(
          "get",
          "/contacts",
          {},
          { params: params },
        );
        this.contacts = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
  },
  async created() {
    await this.getContacts();
  },
  components: { HeadingTwo, ContentWrapper, HeadingThree },
};
</script>
