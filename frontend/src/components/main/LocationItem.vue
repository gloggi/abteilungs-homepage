<template>
  <div>
    <MapComponent
      v-if="item?.location"
      class="w-full h-96"
      :markers="[item.location]"
    />
  </div>
</template>
<script>
import MapComponent from "./MapComponent.vue";

export default {
  props: ["item"],
  data() {
    return {};
  },
  methods: {},
  async created() {},
  components: { MapComponent },
};
</script>
