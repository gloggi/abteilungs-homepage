<template>
  <TextInput
    @click="highlightValue"
    :label="label"
    :id="id"
    v-model="inputValue"
    :readonly="true"
  />
</template>
<script>
import TextInput from "./TextInput.vue";
export default {
  components: { TextInput },
  data() {
    return {
      inputValue: this.value,
    };
  },
  props: ["label", "value", "id"],
  methods: {
    highlightValue(event) {
      event.target.select();
    },
  },
};
</script>
