<template>
  <ContentWrapper>
    <HeadingTwo class="w-full text-primary">{{
      $t("page.contact")
    }}</HeadingTwo>
    <div class="flex flex-col space-y-5">
      <div
        v-for="contact in contacts"
        :key="contact.id"
        class="flex flex-col space-y-3 md:space-y-0 md:flex-row justify-between w-full"
      >
        <div class="flex flex-col main-text">
          <HeadingThree class="text-primary">
            {{ contact.role }}
          </HeadingThree>
          <p>
            {{ contact.firstname }} {{ contact.lastname }}
            {{ contact.nickname ? "v/o" : "" }} {{ contact.nickname }}
          </p>
          <a
            class="link hover:text-secondary"
            :href="`mailto:${contact.email}`"
            >{{ contact.email }}</a
          >
        </div>

        <img
          v-if="contact.file?.path"
          :src="backendURL + contact.file.path"
          class="w-36 h-36 object-cover rounded-full self-center"
        />
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
        const response = await this.callApi(
          "get",
          "/contacts",
          {},
          { params: { perPage: 100 } },
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
