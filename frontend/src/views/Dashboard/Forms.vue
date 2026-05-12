<template>
  <OverviewTemplate
    :name="$t('dashboard.forms')"
    entity="forms"
    :columns="[
      { key: 'name', title: $t('dashboard.name'), type: 'link', linkKey: 'id' },
      { key: 'email', title: $t('dashboard.email') },
    ]"
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
