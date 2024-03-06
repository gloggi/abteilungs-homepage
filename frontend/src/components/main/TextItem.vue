<template>
  <ContentWrapper>
    <FleurDeLis class="hidden md:flex" v-if="item.showFleurDeLis" />
    <HeadingTwo class="text-primary">{{ item.title }}</HeadingTwo>
    <div v-html="item.body" v-router-link></div>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import FleurDeLis from "./FleurDeLis.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["item"],
  data() {
    return {};
  },
  methods: {},
  async created() {},
  components: { HeadingTwo, FleurDeLis, ContentWrapper },
};
</script>
