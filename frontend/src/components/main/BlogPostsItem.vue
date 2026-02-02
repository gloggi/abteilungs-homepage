<template>
  <ContentWrapper>
    <HeadingThree v-if="item.viewMode !== 'hidden'" class="mb-8 text-primary">
      {{ $t("blog.title") }}
    </HeadingThree>

    <BlogList :limit="item.limit" />
  </ContentWrapper>
</template>

<script>
import BlogList from "./BlogList.vue";
import ContentWrapper from "./ContentWrapper.vue";
import HeadingThree from "./HeadingThree.vue";

export default {
  components: {
    BlogList,
    ContentWrapper,
    HeadingThree,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
