<template>
  <BigHeader v-if="group.page.bigHeader" :images="group.page.files" />
  <SmallHeader v-else :title="group.page.title" :images="group.page.files" />
  <slot name="navbar"></slot>
  <PageBuilder :page="group.page" />
</template>
<script>
import BigHeader from "../components/main/BigHeader.vue";
import PageBuilder from "../components/main/PageBuilder.vue";
import SmallHeader from "../components/main/SmallHeader.vue";

export default {
  components: {
    BigHeader,
    PageBuilder,
    SmallHeader,
  },
  props: {
    group: { type: Object, required: true },
  },
};
</script>
