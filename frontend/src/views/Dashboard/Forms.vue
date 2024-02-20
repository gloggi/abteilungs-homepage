<template>
  <OverviewTemplate
    :name="$t('dashboard.forms')"
    entity="forms"
    :titles="`${$t('dashboard.name')},${$t('dashboard.email')}`"
    columns="name:link(id),email"
    pushAfterCreationTo="Form"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
