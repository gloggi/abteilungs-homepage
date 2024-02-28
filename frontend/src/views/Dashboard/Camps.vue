<template>
  <OverviewTemplate
    :name="$t('dashboard.camps')"
    entity="camps"
    :titles="`${$t('dashboard.name')},${$t('dashboard.startAt')},${$t(
      'dashboard.finishAt',
    )},${$t('dashboard.participants')}`"
    columns="name:link(id),startAt:date,finishAt:date,participantCount"
    pushAfterCreationTo="Camp"
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
