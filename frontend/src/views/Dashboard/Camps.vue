<template>
  <OverviewTemplate
    :name="$t('dashboard.camps')"
    entity="camps"
    :columns="[
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
      { key: 'startDate', title: $t('dashboard.startAt'), type: 'date' },
      { key: 'finishDate', title: $t('dashboard.finishAt'), type: 'date' },
      { key: 'participantCount', title: $t('dashboard.participants') },
    ]"
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
