<template>
  <ContentWrapper>
    <LogoCircle
      v-if="item.logoCircle"
      :logoCircle="item.logoCircle"
      class="hidden md:flex"
    />
    <HeadingTwo class="text-primary">{{ item.title }}</HeadingTwo>
    <div v-html="item.body" v-router-link></div>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import LogoCircle from "./LogoCircle.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["item"],
  data() {
    return {};
  },
  methods: {},
  async created() {},
  components: { HeadingTwo, LogoCircle, ContentWrapper },
};
</script>
