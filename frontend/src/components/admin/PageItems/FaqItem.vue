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
        selection="FaqItem"
        @selectFaqItem="handleChange"
        :value="item.faqId"
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
    "changeFaq",
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
    async getFaqs() {
      try {
        const response = await this.callApi("get", "faqs");
        this.options = response.data.data.map((faq) => {
          return { id: faq.id, name: faq.title };
        });
      } catch (error) {
        console.log(error);
      }
    },
    handleChange(value) {
      this.$emit("changeFaq", { faqId: value, id: this.item.id });
    },
  },

  computed: {},
  async created() {
    await this.getFaqs();
  },
};
</script>

<style></style>
