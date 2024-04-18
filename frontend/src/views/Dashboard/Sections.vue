<template>
  <OverviewTemplate
    :name="$t('dashboard.sections')"
    entity="sections"
    :titles="`${$t('dashboard.logo')},${$t('dashboard.name')},${$t(
      'dashboard.fromAge',
    )},${$t('dashboard.toAge')}`"
    columns="file:image(thumbnail;color),name:link(id),fromAge,toAge"
    pushAfterCreationTo="Section"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
