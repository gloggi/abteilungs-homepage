<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <SelectComponent
      v-model="selectedValue"
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
    "changeForm",
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
    async getForms() {
      try {
        const response = await this.callApi(
          "get",
          "forms",
          {},
          { params: { dashboard: true } },
        );
        this.options = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
  computed: {
    selectedValue: {
      get() {
        return this.item.formId;
      },
      set(value) {
        this.$emit("changeForm", { formId: value, id: this.item.id });
      },
    },
  },
  async created() {
    await this.getForms();
  },
};
</script>

<style></style>
