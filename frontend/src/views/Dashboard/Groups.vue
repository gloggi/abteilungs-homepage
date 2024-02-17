<template>
  <OverviewTemplate
    name="Groups"
    entity="groups"
    titles="Image,Name,Section"
    columns="file:image(thumbnail),name:link(id),section.name"
    pushAfterCreationTo="Group"
  />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
  components: { OverviewTemplate },
};
</script>

<style></style>
