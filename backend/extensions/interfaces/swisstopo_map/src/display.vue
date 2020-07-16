<template>
  <div class="readonly-map">
    <span v-if="value">{{ value.x | coord }} / {{ value.y | coord }}</span>
  </div>
</template>

<script>
  import mixin from "@directus/extension-toolkit/mixins/interface";
  export default {
    name: 'ReadonlySwisstopoMap',
    mixins: [mixin],
    filters: {
      coord(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      }
    }
  };
</script>

<style lang="scss" scoped>
  i {
    cursor: help;
    &.empty {
      color: var(--empty-value);
    }
  }
</style>