<template>
  <OverviewTemplate
    :name="$t('dashboard.locations')"
    entity="locations"
    :columns="[
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
      { key: 'lat', title: $t('dashboard.latitude') },
      { key: 'long', title: $t('dashboard.longitude') },
    ]"
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
