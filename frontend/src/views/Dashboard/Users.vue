<template>
  <OverviewTemplate
    :name="$t('dashboard.users')"
    entity="users"
    :titles="`${$t('dashboard.nickname')},${$t('dashboard.firstName')},${$t(
      'dashboard.lastName',
    )},${$t('dashboard.email')}`"
    columns="nickname:link(id),firstname,lastname,email"
    pushAfterCreationTo="User"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
