<template>
  <OverviewTemplate
    :name="
      settings.isRegion ? $t('dashboard.divisions') : $t('dashboard.groups')
    "
    entity="groups"
    :titles="`${$t('dashboard.image')},${$t('dashboard.name')},${$t(
      'dashboard.section',
    )}`"
    columns="file:image(thumbnail;color),name:link(id),section.name"
    pushAfterCreationTo="Group"
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
