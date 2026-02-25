<template>
  <div
    class="relative group"
    :class="{ 'opacity-50': isDragging }"
    @dragover.prevent.stop="handleDragOver"
    @dragleave.prevent.stop="handleDragLeave"
    @drop.prevent.stop="handleDrop"
    @dragenter.prevent.stop="handleDragEnter"
  >
    <div
      v-if="dropPosition === 'before'"
      class="absolute -top-1 left-0 right-0 h-1 bg-gray-500 rounded z-10 pointer-events-none"
    ></div>

    <div
      class="bg-white border border-gray-200 rounded-md shadow-sm mb-2 hover:border-gray-300 transition-colors"
      :class="{
        'border-gray-500 ring-2 ring-gray-200': dropPosition === 'inside',
      }"
    >
      <div
        class="flex items-center justify-between p-3 cursor-grab active:cursor-grabbing"
        draggable="true"
        @dragstart.stop="handleDragStart"
        @dragend.stop="handleDragEnd"
      >
        <div class="flex items-center gap-3 overflow-hidden">
          <div class="text-gray-400 hover:text-gray-600 px-1">
            <font-awesome-icon :icon="icons.faGripVertical" />
          </div>
          <div class="flex flex-col truncate">
            <span class="font-medium text-gray-900 text-sm truncate">{{
              localItem.title
            }}</span>
            <span class="text-xs text-gray-500 truncate">{{
              itemTypeLabel
            }}</span>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <button
            v-if="canEdit"
            @click.stop="toggleEdit"
            class="p-1.5 text-gray-400 hover:text-gray-900 rounded-md hover:bg-gray-100 transition-colors"
            :class="{ 'text-gray-900 bg-gray-100': showEdit }"
          >
            <font-awesome-icon :icon="icons.faPen" />
          </button>
          <button
            @click.stop="$emit('delete', localItem)"
            class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50 transition-colors"
          >
            <font-awesome-icon :icon="icons.faTrash" />
          </button>
        </div>
      </div>
      <div
        v-if="showEdit"
        class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-md space-y-3 cursor-default"
      >
        <TextInput
          v-model="editForm.title"
          :label="$t('dashboard.title')"
          @update:modelValue="onEditUpdate"
        />
        <TextInput
          v-if="!localItem.page_id"
          v-model="editForm.url"
          :label="$t('dashboard.url')"
          @update:modelValue="onEditUpdate"
        />
      </div>
    </div>
    <div
      v-if="dropPosition === 'after'"
      class="absolute -bottom-1 left-0 right-0 h-1 bg-gray-500 rounded z-10 pointer-events-none"
    ></div>
    <div
      v-if="localItem.children && localItem.children.length > 0"
      class="ml-6 pl-3 border-l-2 border-gray-100 space-y-2 mt-2 mb-2"
    >
      <NavEditorItem
        v-for="child in localItem.children"
        :ref="'child-' + child.id"
        :key="child.id"
        :item="child"
        :level="level + 1"
        @update="updateChild"
        @delete="deleteChild"
        @menu-item-drag-start="$emit('menu-item-drag-start', $event)"
        @menu-item-drop="$emit('menu-item-drop', $event)"
      />
    </div>
  </div>
</template>

<script>
import {
  faGripVertical,
  faPen,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";
import TextInput from "./TextInput.vue";

export default {
  name: "NavEditorItem",
  components: { TextInput },
  props: {
    item: {
      type: Object,
      required: true,
    },
    level: {
      type: Number,
      default: 0,
    },
  },
  emits: ["update", "delete", "menu-item-drag-start", "menu-item-drop"],
  data() {
    return {
      localItem: this.item,
      editForm: {
        title: "",
        url: "",
      },
      showEdit: false,
      isDragging: false,
      dropPosition: null,
      icons: {
        faGripVertical,
        faPen,
        faTrash,
      },
      dragCounter: 0,
    };
  },
  watch: {
    item: {
      handler(newVal) {
        this.localItem = newVal;

        if (!this.showEdit) {
          this.editForm = { title: newVal.title, url: newVal.url };
        }
      },
      deep: true,
      immediate: true,
    },
  },
  computed: {
    itemTypeLabel() {
      if (this.localItem.special) return this.$t("dashboard.specialItems");
      if (this.localItem.type === "customItem")
        return this.$t("dashboard.customLinks");
      if (this.localItem.page_id || this.localItem.pageId)
        return this.$t("dashboard.page");
      return this.localItem.url;
    },
    canEdit() {
      return (
        !this.localItem.page_id &&
        !this.localItem.pageId &&
        !this.localItem.special
      );
    },
  },
  methods: {
    toggleEdit() {
      this.showEdit = !this.showEdit;
      if (this.showEdit) {
        this.editForm = {
          title: this.localItem.title,
          url: this.localItem.url,
        };
      }
    },
    onEditUpdate() {
      this.$emit("update", {
        id: this.localItem.id,
        tempId: this.localItem.tempId,
        title: this.editForm.title,
        url: this.editForm.url,
      });
    },

    handleDragStart(e) {
      this.isDragging = true;
      e.dataTransfer.effectAllowed = "move";
      e.dataTransfer.setData(
        "application/json",
        JSON.stringify({
          item: this.localItem,
          source: "editor",
        }),
      );

      this.$emit("menu-item-drag-start", {
        item: this.localItem,
        element: this.$el,
      });
    },
    handleDragEnd() {
      this.isDragging = false;
      this.dropPosition = null;
      this.dragCounter = 0;
    },

    handleDragEnter() {
      this.dragCounter++;
    },
    handleDragLeave() {
      this.dragCounter--;
      if (this.dragCounter === 0) {
        this.dropPosition = null;
      }
    },
    handleDragOver(e) {
      const rect = e.currentTarget.getBoundingClientRect();
      const y = e.clientY - rect.top;
      const height = rect.height;

      if (this.level >= 1) {
        if (y < height * 0.5) {
          this.dropPosition = "before";
        } else {
          this.dropPosition = "after";
        }
      } else {
        if (y < height * 0.25) {
          this.dropPosition = "before";
        } else if (y > height * 0.75) {
          this.dropPosition = "after";
        } else {
          this.dropPosition = "inside";
        }
      }
    },
    handleDrop(e) {
      const position = this.dropPosition;
      this.dropPosition = null;
      this.dragCounter = 0;

      const data = e.dataTransfer.getData("application/json");
      if (!data) return;

      try {
        const payload = JSON.parse(data);

        this.$emit("menu-item-drop", {
          targetId: this.localItem.id || this.localItem.tempId,
          targetLevel: this.level,
          position: position,
          draggedItem: payload.item,
          source: payload.source,
        });
      } catch (err) {
        console.error("Drop error", err);
      }
    },
    updateChild(payload) {
      this.$emit("update", payload);
    },
    deleteChild(child) {
      this.$emit("delete", child);
    },
  },
};
</script>
