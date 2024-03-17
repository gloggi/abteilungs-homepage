<template>
  <router-link
    v-if="!group.externalLink"
    :to="group.hasPage ? `/group/${group.route}` : '#'"
    >{{ group.name }}</router-link
  >
  <a v-else :href="group.externalLink" target="_blank">{{ group.name }}</a>
</template>
<script>
export default {
  props: {
    group: {
      type: Object,
      required: true,
    },
  },
};
</script>
