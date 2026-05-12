<template>
  <OverviewTemplate
    :name="$t('dashboard.blogPosts')"
    entity="blogposts"
    :columns="[
      {
        key: 'title',
        title: $t('dashboard.title'),
        type: 'link',
        linkKey: 'id',
      },
      { key: 'slug', title: $t('dashboard.slug') },
      { key: 'published_at', title: $t('dashboard.publishedAt') },
      { key: 'active', title: $t('dashboard.active') },
    ]"
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
