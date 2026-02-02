<template>
  <OverviewTemplate
    :name="$t('dashboard.blogPosts')"
    entity="blogposts"
    :titles="`${$t('dashboard.title')},${$t('dashboard.slug')},${$t(
      'dashboard.publishedAt',
    )},${$t('dashboard.active')}`"
    columns="title:link(id),slug,published_at,active"
    pushAfterCreationTo="BlogPost"
    :create="true"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>
