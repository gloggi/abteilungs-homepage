<template>
  <OverviewTemplate
    :name="
      settings.isRegion ? $t('dashboard.divisions') : $t('dashboard.groups')
    "
    entity="groups"
    :columns="[
      {
        key: 'file',
        title: $t('dashboard.logo'),
        type: 'image',
        imageField: 'thumbnail',
        useColor: true,
      },
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
      { key: 'section.name', title: $t('dashboard.section') },
    ]"
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
