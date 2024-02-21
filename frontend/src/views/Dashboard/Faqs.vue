<template>
  <OverviewTemplate
    :name="$t('dashboard.faqs')"
    entity="faqs"
    :titles="`${$t('dashboard.title')}`"
    columns="title:link(id)"
    pushAfterCreationTo="Faq"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
