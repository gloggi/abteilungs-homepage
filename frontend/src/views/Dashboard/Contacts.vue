<template>
  <OverviewTemplate
    name="Contacts"
    entity="contacts"
    titles="Image,Nickname,Vorname,Nachname,E-Mail"
    columns="file:image(thumbnail),nickname:link(id),firstname,lastname,email"
    pushAfterCreationTo="Contact" />
</template>

<script>
import OverviewTemplate from '../../components/admin/OverviewTemplate.vue';


export default {
  components: { OverviewTemplate },
  
};
</script>

<style>
</style>