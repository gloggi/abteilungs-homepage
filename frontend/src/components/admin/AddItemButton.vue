<template>
  <button
    @click="openModal"
    @dragenter.prevent="increaseHeight = true"
    @dragleave.prevent="increaseHeight = false"
    @dragover.prevent
    @drop="handleDrop"
    class="rounded-lg my-1 w-full text-xs hover:text-white transition-all duration-200 flex items-center justify-center"
    :class="buttonClasses"
  >
    <span v-if="dragging">{{ dragText }}</span>
    <span v-else class="flex items-center gap-1">
      <font-awesome-icon :icon="icons.faPlus" />
      {{ addText }}
    </span>
  </button>
  <Modal v-if="showModal" @close="closeModal" :size="modalSize">
    <div class="p-1">
      <h1 class="text-3xl font-bold pb-4 text-gray-900">{{ modalTitle }}</h1>
      <div 
        class="grid grid-cols-2 lg:grid-cols-4 gap-4" 
        :class="{'overflow-y-auto': true}"
      >
        <div
          v-for="(item, index) in items"
          :key="index"
          @click="select(item)"
          class="group flex flex-col bg-gray-100 hover:bg-gray-200 rounded-xl p-3 space-y-3 cursor-pointer transition-all border border-transparent hover:border-gray-300 shadow-sm hover:shadow-md"
        >
          <div
            class="aspect-square bg-white rounded-lg flex justify-center items-center p-4 shadow-inner group-hover:scale-105 transition-transform duration-200"
          >
            <component 
              :is="item.component" 
              class="h-full w-full text-gray-700" 
              v-if="item.component"
            />
            <p v-else class="font-serif text-5xl text-gray-400 select-none">
              {{ item.name ? item.name.substring(0, 1) : '?' }}
            </p>
          </div>
          <div class="px-1">
            <p class="font-medium text-sm text-center text-gray-800 break-words leading-tight group-hover:text-black">
              {{ item.name }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </Modal>
</template>

<script>
import Modal from "./Modal.vue";
import { faPlus } from "@fortawesome/free-solid-svg-icons";

export default {
  name: "AddItemButton",
  components: {
    Modal,
  },
  props: {
    items: {
      type: Array,
      required: true,

    },
    dragging: {
      type: Boolean,
      default: false,
    },
    dragText: {
      type: String,
      default: "Drop here",
    },
    addText: {
      type: String,
      default: "Add Item",
    },
    modalTitle: {
      type: String,
      default: "Select Item",
    },
    sortKey: {
      type: Number,
      required: true,
    },
    modalSize: {
      type: String,
      default: "xl", 
    },
  },
  emits: ["select", "changeOrder"],
  data() {
    return {
      showModal: false,
      increaseHeight: false,
      icons: {
        faPlus,
      },
    };
  },
  computed: {
    buttonClasses() {

      let classes = [];
      

      if (this.dragging) {
        classes.push('bg-gray-100 border-2 border-dashed border-gray-400 text-gray-900 shadow-inner');
      } else {
        classes.push('bg-white hover:bg-gray-50 text-gray-500 hover:text-gray-900 border border-dashed border-gray-300 hover:border-gray-400');
      }


      if (this.increaseHeight) {
        classes.push('h-32');
      } else {
        classes.push('min-h-[2.5rem] py-2'); 
      }

      return classes.join(' ');
    },
  },
  methods: {
    openModal() {
      this.showModal = true;
      this.increaseHeight = false;
    },
    closeModal() {
      this.showModal = false;
    },
    handleDrop(e) {
      this.increaseHeight = false;
      const data = e.dataTransfer.getData("text");
      try {
        if (data) {
          const field = JSON.parse(data);
          field.sort = this.sortKey + 0.5;
          this.$emit("changeOrder", field);
        }
      } catch (err) {
        console.error("Failed to parse drop data", err);
      }
    },
    select(item) {
      const { component, ...rest } = item;

      this.$emit("select", { ...rest, sort: this.sortKey + 0.5 });
      this.closeModal();
    },
  },
};
</script>
