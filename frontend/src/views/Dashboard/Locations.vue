<template>
  <OverviewTemplate
    :name="$t('dashboard.locations')"
    entity="locations"
    :titles="`${$t('dashboard.name')},${$t('dashboard.latitude')},${$t(
      'dashboard.longitude',
    )}`"
    columns="name:link(id),lat,long"
    pushAfterCreationTo="Location"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
