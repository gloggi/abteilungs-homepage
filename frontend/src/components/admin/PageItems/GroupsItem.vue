<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <p>{{ $t("dashboard.groupsMessage") }}</p>
  </DragItemBox>
</template>

<script>
import DragItemBox from "../DragItemBox.vue";

export default {
  components: { DragItemBox },
  props: ["boxTitle", "item"],
  emits: ["delete", "startedDragging", "endedDragging"],
  data() {
    return {
      options: [],
    };
  },
  methods: {},

  computed: {},
  async created() {},
};
</script>

<style></style>
