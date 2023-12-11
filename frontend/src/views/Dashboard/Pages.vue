<template>
  <OverviewTemplate
    name="Pages"
    entity="pages"
    titles="Titel,Permalink"
    columns="title:link(id),route"
    pushAfterCreationTo="Page" />
</template>

<script>
import OverviewTemplate from '../../components/admin/OverviewTemplate.vue';


export default {
  components: { OverviewTemplate },
  
};
</script>

<style>
</style>