<template>
  <div class="text-xs text-gray-500 flex items-center space-x-1 pt-1 pl-1">
    <font-awesome-icon :icon="icons.faInfoCircle" />
    <p>{{ info }}</p>
  </div>
</template>
<script>
import { faInfoCircle } from "@fortawesome/free-solid-svg-icons";
export default {
  props: ["info"],
  data() {
    return {
      icons: {
        faInfoCircle,
      },
    };
  },
};
</script>
