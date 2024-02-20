<template>
  <OverviewTemplate
    :name="$t('dashboard.groups')"
    entity="groups"
    :titles="`${$t('dashboard.image')},${$t('dashboard.name')},${$t(
      'dashboard.section',
    )}`"
    columns="file:image(thumbnail),name:link(id),section.name"
    pushAfterCreationTo="Group"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
