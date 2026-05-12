<template>
  <OverviewTemplate
    :name="$t('dashboard.users')"
    entity="users"
    :columns="[
      {
        key: 'nickname',
        title: $t('dashboard.nickname'),
        type: 'link',
        linkKey: 'id',
      },
      { key: 'firstname', title: $t('dashboard.firstName') },
      { key: 'lastname', title: $t('dashboard.lastName') },
      { key: 'email', title: $t('dashboard.email') },
    ]"
    pushAfterCreationTo="User"
    :create="false"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
