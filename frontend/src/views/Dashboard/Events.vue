<template>
  <OverviewTemplate
    :name="$t('dashboard.events')"
    entity="events"
    :columns="[
      {
        key: 'title',
        title: $t('dashboard.title'),
        type: 'link',
        linkKey: 'id',
      },
      { key: 'startTime', title: $t('dashboard.start'), type: 'date' },
      { key: 'endTime', title: $t('dashboard.end'), type: 'date' },
      {
        key: 'groups',
        title: $t('dashboard.groups'),
        type: 'list',
        listKey: 'name',
      },
    ]"
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
