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
        selection="FormItem"
        @selectFormItem="handleChange"
        :value="item.formId"
        :options="options"
      />
    </Card>
  </DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import SelectComponent from "../SelectComponent.vue";
import DragItemBox from "../DragItemBox.vue";

export default {
  components: { Card, SelectComponent, DragItemBox },
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
    handleChange(value) {
      this.$emit("changeForm", { formId: value, id: this.item.id });
    },
  },

  computed: {},
  async created() {
    await this.getForms();
  },
};
</script>

<style></style>
