<template>
  <OverviewTemplate
    name="Forms"
    entity="forms"
    titles="Name,E-Mail"
    columns="name:link(id),email"
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
