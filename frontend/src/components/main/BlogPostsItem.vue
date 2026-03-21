<template>
  <ContentWrapper>
    <BlogList :limit="item.limit" />
  </ContentWrapper>
</template>

<script>
import BlogList from "./BlogList.vue";
import ContentWrapper from "./ContentWrapper.vue";

export default {
  components: {
    BlogList,
    ContentWrapper,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
};
</script>
