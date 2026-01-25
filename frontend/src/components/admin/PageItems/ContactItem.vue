<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <p>{{ $t("dashboard.contactsMessage") }}</p>
    <MultipleSelect
      :options="options"
      v-model="item.groups"
      :label="$t('dashboard.groups')"
      :id="`contact-groups-${item.id || item.tempId}`"
    />
  </DragItemBox>
</template>

<script>

import DragItemBox from "../DragItemBox.vue";
import MultipleSelect from "../MultipleSelect.vue";

export default {
  components: { DragItemBox, MultipleSelect },
  props: ["boxTitle", "item"],
  emits: ["delete", "startedDragging", "endedDragging"],
  data() {
    return {
      options: [],
    };
  },
  methods: {
    async getGroups() {
      try {
        const response = await this.callApi("get", "/groups");
        this.options = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    changeGroups(vals) {
        this.item.groups = vals;
    }
  },
  async created() {
      await this.getGroups();
      if (this.item.groups && this.item.groups.length > 0 && typeof this.item.groups[0] === 'object') {
          this.item.groups = this.item.groups.map(g => g.id);
      }
  },
};
</script>

<style></style>
