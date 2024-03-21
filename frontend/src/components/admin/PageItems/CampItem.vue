<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card class="space-y-2">
      <SelectComponent
        selection="Group"
        @selectGroup="handleChange"
        :value="item.groupId"
        :options="options"
      />
    </Card>
  </DragItemBox>
</template>
<script>
import Card from "../Card.vue";
import DragItemBox from "../DragItemBox.vue";
import SelectComponent from "../SelectComponent.vue";

export default {
  components: { Card, DragItemBox, SelectComponent },
  props: ["boxTitle", "item"],
  emits: ["delete", "startedDragging", "endedDragging", "changeCamp"],
  data() {
    return {
      options: [],
    };
  },
  methods: {
    async getGroups() {
      try {
        const response = await this.callApi("get", "groups");
        this.options = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    handleChange(value) {
      this.$emit("changeCamp", { groupId: value, id: this.item.id });
    },
  },

  computed: {},
  async created() {
    await this.getGroups();
  },
};
</script>

<style></style>
