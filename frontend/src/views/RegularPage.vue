<template>
  <slot
    v-if="settings && settings.navbarPosition === 'top'"
    name="navbar"
  ></slot>
  <template v-if="page.bigHeader">
    <BigHeader :images="page.files" />
  </template>
  <template v-else>
    <SmallHeader :title="page.title" :images="page.files" />
  </template>
  <slot
    v-if="settings && settings.navbarPosition !== 'top'"
    name="navbar"
  ></slot>
  <PageBuilder :page="page" />
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
    page: { type: Object, required: true },
  },
};
</script>
<style></style>
