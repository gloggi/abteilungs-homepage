<template>
  <div
    :draggable="allowDrag"
    @dragstart="dragStart"
    @dragend="dragEnd"
    class="flex flex-col rounded-md border border-gray-200 bg-white shadow-sm text-left group hover:border-gray-300 transition-colors"
  >
    <div class="p-4 space-y-4">
      <div
        id="dragbutton"
        class="w-full flex justify-center text-gray-400 hover:text-gray-600 cursor-grab -mt-1 mb-2 transition-colors"
        @mouseover="allowDrag = true"
        @mouseleave="allowDrag = false"
      >
        <font-awesome-icon :icon="icons.faGripHorizontal" />
      </div>
      <TextInput
        id="title"
        :label="$t('dashboard.title')"
        v-model="customMenuItem.title"
      />
      <TextInput
        id="url"
        :label="$t('dashboard.url')"
        placeholder="https://"
        v-model="customMenuItem.url"
      />
    </div>
  </div>
</template>
<script>
import TextInput from "./TextInput.vue";
import { faGripHorizontal } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { TextInput },
  props: ["item"],
  emits: ["startedDragging", "endedDragging"],
  data() {
    return {
      customMenuItem: {
        title: undefined,
        url: undefined,
        type: "customItem",
      },
      allowDrag: false,
      icons: {
        faGripHorizontal,
      },
    };
  },
  methods: {
    dragStart(e) {
      e.dataTransfer.setData("text/plain", JSON.stringify(this.customMenuItem));

      this.$emit("startedDragging", true);
    },
    dragEnd() {
      this.allowDrag = false;
      this.$emit("endedDragging", true);
    },
  },
};
</script>
