<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <SelectComponent v-model="selectedValue" :options="options" />
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
        const response = await this.callApi(
          "get",
          "faqs",
          {},
          { params: { dashboard: true } },
        );
        this.options = response.data.data.map((faq) => {
          return { id: faq.id, name: faq.title };
        });
      } catch (error) {
        console.log(error);
      }
    },
  },
  computed: {
    selectedValue: {
      get() {
        return this.item.faqId;
      },
      set(value) {
        this.$emit("changeFaq", { faqId: value, id: this.item.id });
      },
    },
  },
  async created() {
    await this.getFaqs();
  },
};
</script>

<style></style>
