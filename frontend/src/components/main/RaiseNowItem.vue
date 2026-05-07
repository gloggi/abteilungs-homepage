<template>
  <div class="flex justify-center my-8">
    <div :id="containerId" class="rnw-widget-container"></div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      instanceId: Math.random().toString(36).substr(2, 9),
    };
  },
  computed: {
    solutionId() {
      return this.settings?.raisenowUuid;
    },
    containerId() {
      return this.solutionId ? `rnw-paylink-button-${this.solutionId}-${this.instanceId}` : "rnw-paylink-button-missing";
    }
  },
  mounted() {
    this.loadRaiseNowWidget();
  },
  methods: {
    async loadRaiseNowWidget() {
      if (!this.solutionId) {
        return;
      }

      try {
        const module = await import("https://unpkg.com/@raisenow/paylink-button@2/dist/TwintButton.js");
        module.TwintButton.render(`#${this.containerId}`, {
          "solution-id": this.solutionId,
          "solution-type": "donate",
          "language": "de",
          "size": "large",
          "width": "fixed",
          "color-scheme": "dark",
        });
      } catch (error) {
        console.error("Failed to load RaiseNow widget module:", error);
      }
    }
  }
};
</script>

<style scoped>
.rnw-widget-container {
  min-height: 50px;
}
</style>
