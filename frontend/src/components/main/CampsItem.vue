<template>
  <ContentWrapper>
    <HeadingOne class="w-full text-primary mb-2">Lager</HeadingOne>
    <Camp v-for="camp in camps" :camp="camp" />
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import Camp from "./Camp.vue";
import HeadingOne from "./HeadingOne.vue";

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
        const response = await this.callApi("get", "camps");
        this.camps = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  async created() {
    await this.getCamps();
  },
  components: { ContentWrapper, Camp, HeadingOne },
};
</script>
