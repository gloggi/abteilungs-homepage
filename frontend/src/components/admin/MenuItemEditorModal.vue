<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
      <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">{{ $t('dashboard.editMenuItem') || 'Edit Menu Item' }}</h3>
      
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">{{ $t('dashboard.title') }}</label>
          <input
            v-model="localItem.title"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
          />
        </div>
        
        <div v-if="localItem.type === 'customItem' || !localItem.page_id">
          <label class="block text-sm font-medium text-gray-700">{{ $t('dashboard.url') }}</label>
          <input
            v-model="localItem.url"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2"
          />
        </div>
      </div>

      <div class="mt-6 flex justify-end space-x-3">
        <button
          @click="close"
          class="rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm"
        >
          {{ $t('dashboard.cancel') || 'Cancel' }}
        </button>
        <button
          @click="save"
          class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-sm"
        >
          {{ $t('dashboard.save') || 'Save' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MenuItemEditorModal",
  props: {
    isOpen: Boolean,
    item: Object,
  },
  emits: ["close", "save"],
  data() {
    return {
      localItem: { ...this.item },
    };
  },
  watch: {
    item(newVal) {
      this.localItem = { ...newVal };
    },
  },
  methods: {
    close() {
      this.$emit("close");
    },
    save() {
      this.$emit("save", this.localItem);
    },
  },
};
</script>
