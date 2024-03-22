<template>
  <router-link v-if="group.hasPage" :to="`/group/${group.route}`">{{
    group.name
  }}</router-link>
  <a
    v-else-if="group.externalLink"
    :href="group.externalLink"
    target="_blank"
    >{{ group.name }}</a
  >
  <span v-else>{{ group.name }}</span>
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
