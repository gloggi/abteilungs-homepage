<template>
  <OverviewTemplate
    :name="$t('dashboard.faqs')"
    entity="faqs"
    :columns="[
      {
        key: 'title',
        title: $t('dashboard.title'),
        type: 'link',
        linkKey: 'id',
      },
    ]"
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
