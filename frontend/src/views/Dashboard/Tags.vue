<template>
  <OverviewTemplate
    :name="$t('dashboard.tags')"
    entity="tags"
    :titles="`${$t('dashboard.name')}`"
    columns="name:link(id)"
    pushAfterCreationTo="Tag"
    :create="isAdmin"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>
