<template>
  <SmallHeader :title="group.name" :images="group.headerImages" />
  <slot name="navbar"></slot>
  <GroupPageComponent :group="group" />
</template>
<script>
import SmallHeader from "../components/main/SmallHeader.vue";
import GroupPageComponent from "../components/main/GroupPageComponent.vue";
export default {
  components: {
    SmallHeader,
    GroupPageComponent,
  },
  props: {
    group: { type: Object, required: true },
  },
};
</script>
