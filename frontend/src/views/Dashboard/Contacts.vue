<template>
  <OverviewTemplate
    :name="$t('dashboard.contacts')"
    entity="contacts"
    :titles="`${$t('dashboard.logo')},${$t('dashboard.nickname')},${$t(
      'dashboard.role',
    )},${$t('dashboard.email')}`"
    columns="file:image(thumbnail;rounded),nickname:link(id),role,email"
    pushAfterCreationTo="Contact"
    :cover="true"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
