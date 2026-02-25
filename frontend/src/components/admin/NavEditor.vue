<template>
  <Card class="min-h-[200px] flex flex-col">
    <div
      class="flex-grow space-y-2 relative"
      @dragover.prevent="handleRootDragOver"
      @dragleave="handleRootDragLeave"
      @drop="handleRootDrop"
    >
      <div
        v-if="localItems.length === 0"
        class="absolute inset-0 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300 rounded-lg m-4"
      >
        {{ $t("dashboard.dragItemsHere") || "Drag items here to start" }}
      </div>

      <NavEditorItem
        v-for="item in localItems"
        :key="item.id || item.tempId"
        :item="item"
        :level="0"
        @update="updateItem"
        @delete="deleteItem"
        @menu-item-drag-start="handleDragStart"
        @menu-item-drop="handleItemDrop"
      />

      <div
        v-if="rootDropActive"
        class="h-2 bg-gray-500 rounded mt-2 transition-all"
      ></div>
    </div>
  </Card>
</template>

<script>
import NavEditorItem from "./NavEditorItem.vue";
import Card from "./Card.vue";

export default {
  name: "NavEditor",
  components: { NavEditorItem, Card },

  props: {
    items: {
      type: Array,
      default: () => [],
    },
  },
  emits: ["update:items", "edit-request"],
  data() {
    return {
      localItems: [],
      rootDropActive: false,
    };
  },
  watch: {
    items: {
      handler(val) {
        this.localItems = JSON.parse(JSON.stringify(val));
      },
      immediate: true,
      deep: true,
    },
  },
  methods: {
    handleDragStart(_payload) {},
    handleRootDragOver(_e) {
      this.rootDropActive = true;
    },
    handleRootDragLeave(_e) {
      this.rootDropActive = false;
    },
    handleRootDrop(e) {
      this.rootDropActive = false;
      const data = e.dataTransfer.getData("application/json");
      if (!data) return;
      const payload = JSON.parse(data);

      this.handleDropLogic(payload.item, payload.source, null, "end", 0);
    },
    handleItemDrop(e) {
      this.handleDropLogic(
        e.draggedItem,
        e.source,
        e.targetId,
        e.position,
        e.targetLevel,
      );
    },

    handleDropLogic(draggedItem, source, targetId, position, targetLevel = 0) {
      const MAX_DEPTH = 1;

      const getItemDepth = (item) => {
        if (!item.children || item.children.length === 0) return 0;
        return 1 + Math.max(...item.children.map(getItemDepth));
      };

      const draggedDepth = getItemDepth(draggedItem);
      let newLevel = targetLevel;

      if (position === "inside") {
        newLevel = targetLevel + 1;
      }

      if (newLevel + draggedDepth > MAX_DEPTH) {
        alert(
          this.$t("dashboard.maxDepthExceeded") ||
            "Max menu depth exceeded (2 levels only).",
        );
        return;
      }

      let itemToInsert = draggedItem;
      if (source === "available") {
        itemToInsert = {
          ...draggedItem,
          id: null,
          tempId: "temp_" + Date.now() + Math.random(),
          children: [],
        };
      } else {
        const found = this.findAndRemove(
          this.localItems,
          itemToInsert.id || itemToInsert.tempId,
        );
        if (found) itemToInsert = found;
      }

      if (targetId === null && position === "end") {
        this.localItems.push(itemToInsert);
      } else {
        const { parent, index, node } = this.findNodeAndParent(
          this.localItems,
          targetId,
        );

        if (node) {
          if (position === "inside") {
            if (!node.children) node.children = [];
            node.children.push(itemToInsert);
          } else if (position === "before") {
            parent.splice(index, 0, itemToInsert);
          } else if (position === "after") {
            parent.splice(index + 1, 0, itemToInsert);
          }
        } else {
          this.localItems.push(itemToInsert);
        }
      }

      this.emitUpdate();
    },

    findAndRemove(list, id) {
      for (let i = 0; i < list.length; i++) {
        if (
          (list[i].id && list[i].id === id) ||
          (list[i].tempId && list[i].tempId === id)
        ) {
          return list.splice(i, 1)[0];
        }
        if (list[i].children) {
          const found = this.findAndRemove(list[i].children, id);
          if (found) return found;
        }
      }
      return null;
    },

    findNodeAndParent(list, id) {
      for (let i = 0; i < list.length; i++) {
        const item = list[i];

        if (
          (item.id && item.id === id) ||
          (item.tempId && item.tempId === id)
        ) {
          return { parent: list, index: i, node: item };
        }
        if (item.children) {
          const result = this.findNodeAndParent(item.children, id);
          if (result) return result;
        }
      }
      return null;
    },

    deleteItem(item) {
      this.findAndRemove(this.localItems, item.id || item.tempId);
      this.emitUpdate();
    },

    updateItem(updatedItem) {
      const id = updatedItem.id || updatedItem.tempId;
      const { node, parent, index } = this.findNodeAndParent(
        this.localItems,
        id,
      );
      if (node && parent) {
        parent[index] = { ...node, ...updatedItem };
        this.emitUpdate();
      }
    },

    emitUpdate() {
      this.$emit("update:items", this.localItems);
    },
  },
};
</script>
