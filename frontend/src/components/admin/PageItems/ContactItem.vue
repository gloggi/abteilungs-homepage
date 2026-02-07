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
      v-model="localGroups"
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
      localGroups: this.item.groups || [],
    };
  },
  watch: {
    localGroups(newVal) {
      this.$emit("changeContact", {
        id: this.item.id || this.item.tempId,
        groups: newVal,
      });
    },
    "item.groups"(newVal) {
      this.localGroups = newVal;
    },
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
  },
  async created() {
    await this.getGroups();
    if (
      this.localGroups &&
      this.localGroups.length > 0 &&
      typeof this.localGroups[0] === "object"
    ) {
      this.localGroups = this.localGroups.map((g) => g.id);
    }
  },
};
</script>

<style></style>
