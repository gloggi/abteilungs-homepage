<template>
  <OverviewTemplate
    :name="$t('dashboard.pages')"
    entity="pages"
    :columns="[
      {
        key: 'title',
        title: $t('dashboard.title'),
        type: 'link',
        linkKey: 'id',
      },
      { key: 'route', title: $t('dashboard.path') },
    ]"
    pushAfterCreationTo="Page"
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
