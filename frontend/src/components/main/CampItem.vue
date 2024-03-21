<template>
  <ContentWrapper>
    <HeadingTwo class="w-full text-primary mb-2">{{
      $t("page.camps")
    }}</HeadingTwo>
    <Camp v-for="camp in camps" :camp="camp" :key="camp.id" />
    <p class="main-text" v-if="camps.length == 0">
      {{ $t("page.noCampsAvailable") }}
    </p>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import Camp from "./Camp.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["item"],
  data() {
    return {
      camps: [],
    };
  },
  methods: {
    async getCamps() {
      try {
        const response = await this.callApi(
          "get",
          "camps",
          {},
          { params: { groupId: this.item.groupId } },
        );
        this.camps = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  async created() {
    await this.getCamps();
  },
  components: { ContentWrapper, Camp, HeadingTwo },
};
</script>
