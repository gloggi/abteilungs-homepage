<template>
  <input
    type="checkbox"
    :checked="checked"
    @change="$emit('change', $event)"
    class="rounded-sm border-gray-300 text-gray-900 focus:ring-offset-0 focus:ring-0 cursor-pointer"
    ref="checkbox"
  />
</template>

<script>
export default {
  name: "MasterCheckbox",
  props: {
    checked: {
      type: Boolean,
      default: false,
    },
    indeterminate: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["change"],
  watch: {
    indeterminate: {
      handler(val) {
        this.$nextTick(() => {
          if (this.$refs.checkbox) {
            this.$refs.checkbox.indeterminate = val;
          }
        });
      },
      immediate: true,
    },
  },
};
</script>
