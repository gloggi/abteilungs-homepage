<template>
  <div
    v-if="show"
    class="fixed w-full py-3 px-8 z-50 main-text font-bold rounded-b-lg flex items-center"
    :style="`background-color: ${settings.alertBgColor};color: ${settings.alertTextColor}`"
  >
    <div class="w-full">
      <a
        v-if="settings.alertUrl"
        class="hover:underline"
        :href="settings.alertUrl"
      >
        {{ settings.alertText }}
      </a>
      <span v-else>
        {{ settings.alertText }}
      </span>
    </div>
    <div>
      <button @click="close">
        <font-awesome-icon :icon="icons.faXmark" />
      </button>
    </div>
  </div>
</template>
<script>
import { faXmark } from "@fortawesome/free-solid-svg-icons";
export default {
  data() {
    return {
      show: false,
      icons: {
        faXmark,
      },
    };
  },
  methods: {
    close() {
      console.log(this.settings.alertText);
      localStorage.setItem("alert", this.settings.alertText);
      this.show = false;
    },
  },
  created() {
    if (localStorage.getItem("alert") !== this.settings.alertText) {
      this.show = true;
    }
  },
};
</script>
