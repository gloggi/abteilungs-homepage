<template>
  <OverviewTemplate
    :name="$t('dashboard.pages')"
    entity="pages"
    :titles="`${$t('dashboard.title')},${$t('dashboard.permalink')}`"
    columns="title:link(id),route"
    pushAfterCreationTo="Page"
    :create="isAdmin"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
