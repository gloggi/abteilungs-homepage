<template>
  <div class="w-full">
    <FormLabel :label-for="id">
      {{ label }}
    </FormLabel>
    <div
      class="flex flex-wrap items-center gap-2 w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm ring-offset-white focus-within:outline-none focus-within:ring-2 focus-within:ring-gray-950 focus-within:ring-offset-2 transition-all min-h-[40px]"
      :class="{ 'border-red-500': errors && errors.length }"
      @click="$refs.input.focus()"
    >
      <div
        v-for="(tag, index) in modelValue"
        :key="tag.id || index"
        class="flex items-center gap-1 px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800"
      >
        <span>{{ tag.name }}</span>
        <button
          type="button"
          @click.stop="removeTag(index)"
          class="text-gray-500 hover:text-gray-700 focus:outline-none"
        >
          &times;
        </button>
      </div>

      <div class="relative flex-grow min-w-[120px]">
        <input
          ref="input"
          type="text"
          v-model="search"
          @keydown.enter.prevent="addTag"
          @keydown.tab.prevent="addTag"
          @keydown.backspace="handleBackspace"
          @keydown.down.prevent="moveSelection(1)"
          @keydown.up.prevent="moveSelection(-1)"
          @focus="showSuggestions = true"
          @blur="handleBlur"
          class="w-full border-none outline-none focus:ring-0 text-sm bg-transparent p-0 placeholder:text-gray-500"
          :placeholder="modelValue.length === 0 ? placeholder : ''"
          :id="id"
        />
        <div
          v-if="showSuggestions && filteredSuggestions.length > 0"
          class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200 max-h-60 overflow-auto left-0"
        >
          <ul class="py-1">
            <li
              v-for="(suggestion, index) in filteredSuggestions"
              :key="suggestion.id"
              @mousedown.prevent="selectSuggestion(suggestion)"
              class="px-4 py-2 text-sm cursor-pointer hover:bg-gray-100"
              :class="{ 'bg-gray-100': selectedIndex === index }"
            >
              {{ suggestion.name }}
            </li>
          </ul>
        </div>
      </div>
    </div>
    <InfoField v-if="info" :info="info" />
    <div v-if="errors" class="text-red-400 text-xs">
      {{ errors.join(" ") }}
    </div>
  </div>
</template>

<script>
import FormLabel from "../admin/FormLabel.vue";
import InfoField from "../admin/InfoField.vue";

export default {
  name: "TagInput",
  components: {
    FormLabel,
    InfoField,
  },
  props: {
    modelValue: {
      type: Array,
      default: () => [],
    },
    label: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "Add tags...",
    },
    allowCreate: {
      type: Boolean,
      default: true,
    },
    errors: {
      type: Array,
      default: null,
    },
    id: {
      type: String,
      default: null,
    },
    info: {
      type: String,
      default: null,
    },
  },
  emits: ["update:modelValue"],
  data() {
    return {
      search: "",
      allTags: [],
      showSuggestions: false,
      selectedIndex: -1,
    };
  },
  computed: {
    filteredSuggestions() {
      if (!this.search) return [];
      const searchLower = this.search.toLowerCase();
      const selectedIds = (this.modelValue || []).map((t) => t.id);
      return this.allTags.filter(
        (tag) =>
          tag.name.toLowerCase().includes(searchLower) &&
          !selectedIds.includes(tag.id),
      );
    },
  },
  watch: {
    search() {
      this.selectedIndex = -1;
    },
  },
  async created() {
    await this.fetchTags();
  },
  methods: {
    async fetchTags() {
      try {
        const response = await this.callApi("get", "/tags");
        this.allTags = response.data;
      } catch (e) {
        console.error("Failed to fetch tags", e);
      }
    },
    async addTag() {
      const trimmed = this.search.trim();
      if (!trimmed) return;

      if (
        this.selectedIndex >= 0 &&
        this.filteredSuggestions[this.selectedIndex]
      ) {
        this.selectSuggestion(this.filteredSuggestions[this.selectedIndex]);
        return;
      }

      const exactMatch = this.allTags.find(
        (t) => t.name.toLowerCase() === trimmed.toLowerCase(),
      );
      if (exactMatch) {
        if (!this.modelValue.find((t) => t.id === exactMatch.id)) {
          this.emitUpdate([...this.modelValue, exactMatch]);
        }
        this.search = "";
        return;
      }

      if (this.allowCreate) {
        try {
          const response = await this.callApi("post", "/tags", {
            name: trimmed,
          });
          const newTag = response.data;
          this.allTags.push(newTag);
          this.emitUpdate([...this.modelValue, newTag]);
          this.search = "";
        } catch (e) {
          console.error("Failed to create tag", e);
        }
      }
    },
    selectSuggestion(tag) {
      this.emitUpdate([...this.modelValue, tag]);
      this.search = "";
      this.showSuggestions = false;
    },
    removeTag(index) {
      const newTags = [...this.modelValue];
      newTags.splice(index, 1);
      this.emitUpdate(newTags);
    },
    handleBackspace(e) {
      if (this.search === "" && this.modelValue.length > 0) {
        this.removeTag(this.modelValue.length - 1);
      }
    },
    emitUpdate(tags) {
      this.$emit("update:modelValue", tags);
    },
    handleBlur() {
      setTimeout(() => {
        this.showSuggestions = false;
      }, 200);
    },
    moveSelection(step) {
      const max = this.filteredSuggestions.length - 1;
      if (max < 0) return;

      let newIndex = this.selectedIndex + step;
      if (newIndex < 0) newIndex = max;
      if (newIndex > max) newIndex = 0;

      this.selectedIndex = newIndex;
    },
  },
};
</script>
