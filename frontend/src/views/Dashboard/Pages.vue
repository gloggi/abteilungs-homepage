<template>
  <OverviewTemplate
    name="Pages"
    entity="pages"
    titles="Titel,Permalink"
    columns="Titel,Permalink"
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