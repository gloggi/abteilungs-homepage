<template>
  <div
    class="mb-6 flex flex-col gap-4 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
  >
    <div class="relative w-full sm:flex-1">
      <div
        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
      >
        <font-awesome-icon :icon="faMagnifyingGlass" class="text-gray-400" />
      </div>
      <input
        type="text"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
        :placeholder="placeholder || $t('dashboard.search')"
      />
    </div>

    <div v-if="hasFilters" class="flex w-full items-center gap-2 sm:w-auto">
      <div class="relative w-full sm:w-48">
        <select
          :value="filter"
          @change="$emit('update:filter', $event.target.value)"
          class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
        >
          <option
            v-for="option in filterOptions"
            :key="option.value"
            :value="option.value"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { faMagnifyingGlass } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "SearchField",
  components: {
    FontAwesomeIcon,
  },
  props: {
    modelValue: {
      type: String,
      default: "",
    },
    filter: {
      type: String,
      default: "",
    },
    filterOptions: {
      type: Array,
      default: () => [],
    },
    placeholder: {
      type: String,
      default: "",
    },
  },
  emits: ["update:modelValue", "update:filter"],
  data() {
    return {
      faMagnifyingGlass,
    };
  },
  computed: {
    hasFilters() {
      return this.filterOptions && this.filterOptions.length > 0;
    },
  },
};
</script>
