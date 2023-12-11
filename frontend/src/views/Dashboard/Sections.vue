<template>
  <OverviewTemplate
    name="Sections"
    entity="sections"
    titles="Name,From Age,To Age"
    columns="name:link(id),fromAge,toAge"
    pushAfterCreationTo="Section" />
</template>

<script>
import OverviewTemplate from '../../components/admin/OverviewTemplate.vue';


export default {
  components: { OverviewTemplate },
  
};
</script>

<style>
</style>