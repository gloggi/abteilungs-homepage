<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <SelectComponent
      selection="LocationItem"
      @selectLocationItem="handleChange"
      :value="item.locationId"
      :options="options"
    />
  </DragItemBox>
</template>

<script>
import SelectComponent from "../SelectComponent.vue";
import DragItemBox from "../DragItemBox.vue";

export default {
  components: { SelectComponent, DragItemBox },
  props: ["item", "boxTitle"],
  emits: [
    "updatePage",
    "changeLocation",
    "delete",
    "startedDragging",
    "endedDragging",
  ],
  data() {
    return {
      options: [],
    };
  },
  methods: {
    async getLocations() {
      try {
        const response = await this.callApi("get", "locations");
        this.options = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    handleChange(value) {
      this.$emit("changeLocation", { locationId: value, id: this.item.id });
    },
  },

  computed: {},
  async created() {
    await this.getLocations();
  },
};
</script>

<style></style>
