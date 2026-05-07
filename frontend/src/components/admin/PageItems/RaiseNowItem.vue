<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <p>Hier wird das RaiseNow Twint Spenden-Widget angezeigt. Du musst die Solution Id in den Einstellungen unter RaiseNow eintragen.</p>
  </DragItemBox>
</template>

<script>
import DragItemBox from "../DragItemBox.vue";

export default {
  components: { DragItemBox },
  props: ["boxTitle", "item"],
  emits: ["delete", "startedDragging", "endedDragging"],
};
</script>
