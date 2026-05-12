<template>
  <OverviewTemplate
    :name="$t('dashboard.contacts')"
    entity="contacts"
    :columns="[
      {
        key: 'file',
        title: $t('dashboard.logo'),
        type: 'image',
        imageField: 'thumbnail',
      },
      {
        key: 'nickname',
        title: $t('dashboard.nickname'),
        type: 'link',
        linkKey: 'id',
      },
      { key: 'role', title: $t('dashboard.role') },
      { key: 'email', title: $t('dashboard.email') },
    ]"
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
