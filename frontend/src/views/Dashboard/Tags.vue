<template>
  <OverviewTemplate
    :name="$t('dashboard.tags')"
    entity="tags"
    :columns="[
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
    ]"
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
