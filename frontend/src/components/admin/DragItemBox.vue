<template>
  <div
    class="rounded-xl border border-gray-200 bg-white text-gray-950 shadow-xs"
  >
    <div
      class="flex flex-row items-center justify-between gap-4 p-4 border-b border-gray-100 bg-gray-50/50 rounded-t-xl"
    >
      <div class="flex flex-row items-center gap-3">
        <div
          class="cursor-grab text-gray-400 hover:text-gray-600 active:cursor-grabbing"
          :draggable="true"
          @dragstart="dragStart"
          @dragend="dragEnd"
        >
          <font-awesome-icon :icon="icons.faGripVertical" class="h-5 w-5" />
        </div>
        <div class="font-semibold text-sm text-gray-900">
          {{ boxTitle }}
        </div>
      </div>
      <div class="flex flex-row items-center gap-2">
        <ActionButton
          @click="showDeleteModal = true"
          variant="ghost"
          size="icon"
          :toolTipText="$t('dashboard.delete')"
          class="text-gray-400 hover:text-red-500 hover:bg-red-50"
        >
          <font-awesome-icon :icon="icons.faTrash" class="h-4 w-4" />
        </ActionButton>
      </div>
    </div>
    <div class="p-4">
      <slot></slot>
    </div>
    <ConfirmDeleteModal
      v-if="showDeleteModal"
      @close="showDeleteModal = false"
      @confirm="executeDelete"
    />
  </div>
</template>

<script>
import { faTrash, faGripVertical } from "@fortawesome/free-solid-svg-icons";
import ActionButton from "./ActionButton.vue";
import ConfirmDeleteModal from "./ConfirmDeleteModal.vue";

export default {
  components: { ActionButton, ConfirmDeleteModal },
  props: {
    item: {
      type: Object,
      required: true,
    },
    boxTitle: {
      type: String,
    },
  },
  emits: ["delete", "startedDragging", "endedDragging"],
  data() {
    return {
      icons: {
        faGripVertical,
        faTrash,
      },
      showDeleteModal: false,
    };
  },
  methods: {
    executeDelete() {
      this.showDeleteModal = false;
      this.$emit("delete", this.item);
    },
    dragStart(e) {
      e.dataTransfer.setData("text/plain", JSON.stringify(this.item));
      this.$emit("startedDragging", true);
    },
    dragEnd() {
      this.$emit("endedDragging", true);
    },
  },
};
</script>
