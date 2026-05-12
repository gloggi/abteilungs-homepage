<template>
  <OverviewTemplate
    :name="$t('dashboard.sections')"
    entity="sections"
    :columns="[
      {
        key: 'file',
        title: $t('dashboard.logo'),
        type: 'image',
        imageField: 'thumbnail',
        useColor: true,
      },
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
      { key: 'fromAge', title: $t('dashboard.fromAge') },
      { key: 'toAge', title: $t('dashboard.toAge') },
    ]"
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
