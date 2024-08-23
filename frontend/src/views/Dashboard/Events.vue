<template>
  <OverviewTemplate
    :name="$t('dashboard.events')"
    entity="events"
    :titles="`${$t('dashboard.title')},${$t('dashboard.start')},${$t(
      'dashboard.end',
    )},${$t('dashboard.groups')}`"
    columns="title:link(id),startTime:date,endTime:date,groups:list(name)"
    pushAfterCreationTo="Event"
    :midataSync="true"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
