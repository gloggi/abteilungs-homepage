<template>
  <OverviewTemplate
    name="Locations"
    entity="locations"
    titles="Name,Latitude,Longitude"
    columns="name:link(id),lat,long"
    pushAfterCreationTo="Location" />
</template>

<script>
import OverviewTemplate from '../../components/admin/OverviewTemplate.vue';


export default {
  components: { OverviewTemplate },
  
};
</script>

<style>
</style>