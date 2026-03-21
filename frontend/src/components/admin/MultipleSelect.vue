<template>
  <div class="w-full" ref="container">
    <FormLabel :label-for="id">
      {{ label }}
    </FormLabel>
    <button
      :id="id"
      type="button"
      @click="toggleDropdown"
      class="multiple-select-trigger"
      :class="{ 'multiple-select-trigger--error': errors && errors.length }"
    >
      <div class="multiple-select-trigger__content">
        <div v-if="selectedOptions.length > 0" class="multiple-select-tags">
          <span
            v-for="option in selectedOptions.slice(0, maxVisibleTags)"
            :key="option.id"
            class="multiple-select-tag"
          >
            <span class="multiple-select-tag__text">{{ option.name }}</span>
            <button
              type="button"
              class="multiple-select-tag__remove"
              @click.stop="removeItem(option.id)"
              @mousedown.prevent
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
              </svg>
            </button>
          </span>
          <span v-if="selectedOptions.length > maxVisibleTags" class="multiple-select-tag multiple-select-tag--count">
            +{{ selectedOptions.length - maxVisibleTags }}
          </span>
        </div>
        <span v-else class="multiple-select-placeholder">{{ placeholder }}</span>
      </div>
      <svg
        class="multiple-select-chevron"
        :class="{ 'multiple-select-chevron--open': showDropdown }"
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="m6 9 6 6 6-6"/>
      </svg>
    </button>

    <div v-if="errors && errors.length" class="text-red-400 text-xs mt-1">
      {{ errors.join(" ") }}
    </div>

    <Teleport to="body">
      <Transition name="multiple-select-popover">
        <div
          v-if="showDropdown"
          ref="popover"
          class="multiple-select-popover"
          :class="popoverPlacement === 'top' ? 'multiple-select-popover--top' : ''"
          :style="popoverStyle"
        >
          <div class="multiple-select-search-wrapper">
            <svg class="multiple-select-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
            </svg>
            <input
              ref="searchInput"
              v-model="searchQuery"
              type="text"
              class="multiple-select-search"
              :placeholder="searchPlaceholder"
              @keydown.escape="closeDropdown"
              @keydown.enter.prevent="handleEnter"
              @keydown.down.prevent="moveSelection(1)"
              @keydown.up.prevent="moveSelection(-1)"
            />
          </div>

          <div class="multiple-select-separator"></div>

          <!-- Options List -->
          <div class="multiple-select-options" ref="optionsList">
            <!-- Select All / Clear All -->
            <div v-if="filteredOptions.length > 0 && !searchQuery" class="multiple-select-actions">
              <button
                type="button"
                class="multiple-select-action-btn"
                @click="selectAll"
                @mousedown.prevent
              >
                Alle auswählen
              </button>
              <span class="multiple-select-action-divider">·</span>
              <button
                type="button"
                class="multiple-select-action-btn"
                @click="clearAll"
                @mousedown.prevent
              >
                Alle abwählen
              </button>
            </div>

            <div
              v-for="(option, index) in filteredOptions"
              :key="option.id"
              class="multiple-select-option"
              :class="{
                'multiple-select-option--selected': isSelected(option.id),
                'multiple-select-option--highlighted': highlightedIndex === index,
              }"
              @click="toggleOption(option.id)"
              @mousedown.prevent
              @mouseenter="highlightedIndex = index"
            >
              <div class="multiple-select-check">
                <Transition name="multiple-select-check-anim">
                  <svg
                    v-if="isSelected(option.id)"
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                </Transition>
              </div>
              <span class="multiple-select-option__label">{{ option.name }}</span>
            </div>

            <div
              v-if="allowCreate && searchQuery && canCreateTag"
              class="multiple-select-option multiple-select-option--create"
              :class="{ 'multiple-select-option--highlighted': highlightedIndex === filteredOptions.length }"
              @click="createAndAddTag"
              @mousedown.prevent
              @mouseenter="highlightedIndex = filteredOptions.length"
            >
              <div class="multiple-select-create-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 5v14"/><path d="M5 12h14"/>
                </svg>
              </div>
              <span class="multiple-select-option__label">
                „{{ searchQuery.trim() }}" erstellen
              </span>
            </div>

            <div v-if="filteredOptions.length === 0 && !canCreateTag" class="multiple-select-empty">
              Keine Ergebnisse gefunden
            </div>
          </div>
          <div v-if="selectedOptions.length > 0" class="multiple-select-footer">
            <span class="multiple-select-footer__count">
              {{ selectedOptions.length }} ausgewählt
            </span>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script>
import FormLabel from "./FormLabel.vue";

export default {
  components: { FormLabel },
  emits: ["update:modelValue"],
  props: {
    label: {
      type: String,
    },
    modelValue: {},
    options: {
      default: () => [],
    },
    errors: {
      type: Array,
      default: () => [],
    },
    id: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "Auswählen...",
    },
    searchPlaceholder: {
      type: String,
      default: "Suchen...",
    },
    maxVisibleTags: {
      type: Number,
      default: 3,
    },
    mode: {
      type: String,
      default: "ids",
      validator: (v) => ["ids", "objects"].includes(v),
    },
    fetchUrl: {
      type: String,
      default: null,
    },
    allowCreate: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showDropdown: false,
      searchQuery: "",
      popoverStyle: {},
      popoverPlacement: "bottom",
      fetchedOptions: [],
      highlightedIndex: -1,
    };
  },
  computed: {
    payload: {
      get() {
        return this.modelValue || [];
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },

    allOptions() {
      if (this.fetchUrl) {
        return this.fetchedOptions;
      }
      return this.options;
    },

    selectedIds() {
      if (this.mode === "objects") {
        return (this.modelValue || []).map((o) => o.id);
      }
      return this.modelValue || [];
    },
    selectedOptions() {
      return this.allOptions.filter((o) => this.selectedIds.includes(o.id));
    },
    filteredOptions() {
      if (!this.searchQuery) return this.allOptions;
      const query = this.searchQuery.toLowerCase();
      return this.allOptions.filter((o) =>
        o.name.toLowerCase().includes(query)
      );
    },
    canCreateTag() {
      if (!this.allowCreate || !this.searchQuery.trim()) return false;
      const trimmed = this.searchQuery.trim().toLowerCase();
      return !this.allOptions.some(
        (o) => o.name.toLowerCase() === trimmed
      );
    },
    totalSelectableItems() {
      let count = this.filteredOptions.length;
      if (this.allowCreate && this.searchQuery && this.canCreateTag) {
        count += 1;
      }
      return count;
    },
  },
  watch: {
    searchQuery() {
      this.highlightedIndex = -1;
    },
  },
  async created() {
    if (this.fetchUrl) {
      await this.fetchOptions();
    }
  },
  methods: {
    isSelected(id) {
      return this.selectedIds.includes(id);
    },
    toggleOption(id) {
      if (this.mode === "objects") {
        if (this.isSelected(id)) {
          this.payload = this.payload.filter((o) => o.id !== id);
        } else {
          const option = this.allOptions.find((o) => o.id === id);
          if (option) {
            this.payload = [...this.payload, option];
          }
        }
      } else {
        if (this.isSelected(id)) {
          this.payload = this.payload.filter((i) => i !== id);
        } else {
          this.payload = [...this.payload, id];
        }
      }
    },
    removeItem(id) {
      if (this.mode === "objects") {
        this.payload = this.payload.filter((o) => o.id !== id);
      } else {
        this.payload = this.payload.filter((i) => i !== id);
      }
    },
    selectAll() {
      if (this.mode === "objects") {
        this.payload = [...this.allOptions];
      } else {
        this.payload = this.allOptions.map((o) => o.id);
      }
    },
    clearAll() {
      this.payload = [];
    },
    toggleDropdown() {
      if (this.showDropdown) {
        this.closeDropdown();
      } else {
        this.openDropdown();
      }
    },
    openDropdown() {
      this.showDropdown = true;
      this.searchQuery = "";
      this.highlightedIndex = -1;
      this.$nextTick(() => {
        this.updatePopoverPosition();
        if (this.$refs.searchInput) {
          this.$refs.searchInput.focus();
        }
      });
    },
    closeDropdown() {
      this.showDropdown = false;
      this.searchQuery = "";
      this.highlightedIndex = -1;
    },
    updatePopoverPosition() {
      const trigger = this.$refs.container;
      if (!trigger) return;
      const rect = trigger.getBoundingClientRect();
      const popoverMaxHeight = 320; // 20rem = 320px
      const gap = 4;
      const spaceBelow = window.innerHeight - rect.bottom - gap;
      const spaceAbove = rect.top - gap;

      if (spaceBelow < popoverMaxHeight && spaceAbove > spaceBelow) {
        this.popoverPlacement = "top";
        this.popoverStyle = {
          position: "fixed",
          bottom: `${window.innerHeight - rect.top + gap}px`,
          left: `${rect.left}px`,
          width: `${rect.width}px`,
          zIndex: 9999,
          maxHeight: `${Math.min(spaceAbove, popoverMaxHeight)}px`,
        };
      } else {
        this.popoverPlacement = "bottom";
        this.popoverStyle = {
          position: "fixed",
          top: `${rect.bottom + gap}px`,
          left: `${rect.left}px`,
          width: `${rect.width}px`,
          zIndex: 9999,
          maxHeight: `${Math.min(spaceBelow, popoverMaxHeight)}px`,
        };
      }
    },
    handleClickOutside(event) {
      if (!this.showDropdown) return;
      const container = this.$refs.container;
      const popover = this.$refs.popover;
      if (
        container && !container.contains(event.target) &&
        popover && !popover.contains(event.target)
      ) {
        this.closeDropdown();
      }
    },
    handleScroll() {
      if (this.showDropdown) {
        this.updatePopoverPosition();
      }
    },
    async fetchOptions() {
      try {
        const response = await this.callApi("get", this.fetchUrl);
        this.fetchedOptions = response.data;
      } catch (e) {
        console.error("Failed to fetch options", e);
      }
    },
    async createAndAddTag() {
      const trimmed = this.searchQuery.trim();
      if (!trimmed || !this.fetchUrl) return;

      try {
        const response = await this.callApi("post", this.fetchUrl, {
          name: trimmed,
        });
        const newItem = response.data;
        this.fetchedOptions.push(newItem);

        if (this.mode === "objects") {
          this.payload = [...this.payload, newItem];
        } else {
          this.payload = [...this.payload, newItem.id];
        }

        this.searchQuery = "";
      } catch (e) {
        console.error("Failed to create item", e);
      }
    },
    handleEnter() {
      if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredOptions.length) {
        this.toggleOption(this.filteredOptions[this.highlightedIndex].id);
      } else if (
        this.highlightedIndex === this.filteredOptions.length &&
        this.canCreateTag
      ) {
        this.createAndAddTag();
      } else if (this.canCreateTag) {
        this.createAndAddTag();
      }
    },
    moveSelection(step) {
      const max = this.totalSelectableItems - 1;
      if (max < 0) return;

      let newIndex = this.highlightedIndex + step;
      if (newIndex < 0) newIndex = max;
      if (newIndex > max) newIndex = 0;

      this.highlightedIndex = newIndex;
      this.$nextTick(() => {
        const list = this.$refs.optionsList;
        if (!list) return;
        const items = list.querySelectorAll(
          ".multiple-select-option"
        );
        if (items[this.highlightedIndex]) {
          items[this.highlightedIndex].scrollIntoView({ block: "nearest" });
        }
      });
    },
  },
  mounted() {
    document.addEventListener("mousedown", this.handleClickOutside);
    window.addEventListener("scroll", this.handleScroll, true);
    window.addEventListener("resize", this.handleScroll);
  },
  beforeUnmount() {
    document.removeEventListener("mousedown", this.handleClickOutside);
    window.removeEventListener("scroll", this.handleScroll, true);
    window.removeEventListener("resize", this.handleScroll);
  },
};
</script>

<style scoped>
.multiple-select-trigger {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  min-height: 2.5rem;
  padding: 0.375rem 0.75rem;
  border-radius: 0.375rem;
  border: 1px solid #e5e7eb;
  background: white;
  font-size: 0.875rem;
  line-height: 1.25rem;
  color: #0a0a0a;
  cursor: pointer;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
  text-align: left;
  outline: none;
}

.multiple-select-trigger:hover {
  border-color: #d1d5db;
}

.multiple-select-trigger:focus-visible {
  outline: none;
  box-shadow: 0 0 0 2px white, 0 0 0 4px #0a0a0a;
}

.multiple-select-trigger--error {
  border-color: #ef4444;
}

.multiple-select-trigger__content {
  flex: 1;
  min-width: 0;
  overflow: hidden;
}

/* ── Tags ── */
.multiple-select-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
}

.multiple-select-tag {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.125rem 0.375rem;
  border-radius: 9999px;
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  font-size: 0.75rem;
  line-height: 1rem;
  color: #374151;
  max-width: 10rem;
  transition: background-color 0.15s ease;
}

.multiple-select-tag:hover {
  background: #e5e7eb;
}

.multiple-select-tag--count {
  background: #0a0a0a;
  color: white;
  border-color: #0a0a0a;
  font-weight: 500;
  padding: 0.125rem 0.5rem;
}

.multiple-select-tag__text {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.multiple-select-tag__remove {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: none;
  background: none;
  padding: 0;
  margin: 0;
  color: #9ca3af;
  cursor: pointer;
  border-radius: 9999px;
  transition: color 0.15s ease;
  flex-shrink: 0;
}

.multiple-select-tag__remove:hover {
  color: #374151;
}

/* ── Placeholder ── */
.multiple-select-placeholder {
  color: #9ca3af;
}

/* ── Chevron ── */
.multiple-select-chevron {
  flex-shrink: 0;
  color: #9ca3af;
  transition: transform 0.2s ease;
  margin-left: 0.5rem;
}

.multiple-select-chevron--open {
  transform: rotate(180deg);
}

/* ── Popover ── */
.multiple-select-popover {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  box-shadow:
    0 4px 6px -1px rgb(0 0 0 / 0.1),
    0 2px 4px -2px rgb(0 0 0 / 0.1),
    0 0 0 1px rgb(0 0 0 / 0.03);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* Popover transitions – downward (default) */
.multiple-select-popover-enter-active {
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.multiple-select-popover-leave-active {
  transition: opacity 0.1s ease, transform 0.1s ease;
}
.multiple-select-popover-enter-from {
  opacity: 0;
  transform: translateY(-4px) scale(0.98);
}
.multiple-select-popover-leave-to {
  opacity: 0;
  transform: translateY(-2px) scale(0.99);
}

/* Popover transitions when opening upward */
.multiple-select-popover--top.multiple-select-popover-enter-from {
  opacity: 0;
  transform: translateY(4px) scale(0.98);
}
.multiple-select-popover--top.multiple-select-popover-leave-to {
  opacity: 0;
  transform: translateY(2px) scale(0.99);
}

/* ── Search ── */
.multiple-select-search-wrapper {
  display: flex;
  align-items: center;
  padding: 0.5rem 0.75rem;
  gap: 0.5rem;
}

.multiple-select-search-icon {
  flex-shrink: 0;
  color: #9ca3af;
}

.multiple-select-search {
  flex: 1;
  border: none;
  outline: none;
  font-size: 0.875rem;
  line-height: 1.25rem;
  color: #0a0a0a;
  background: transparent;
  padding: 0;
}

.multiple-select-search:focus {
  outline: none;
  box-shadow: none;
}

.multiple-select-search::placeholder {
  color: #9ca3af;
}

/* ── Separator ── */
.multiple-select-separator {
  height: 1px;
  background: #f3f4f6;
  flex-shrink: 0;
}

/* ── Options ── */
.multiple-select-options {
  overflow-y: auto;
  padding: 0.25rem;
  flex: 1;
}

.multiple-select-option {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.5rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  color: #0a0a0a;
  cursor: pointer;
  user-select: none;
  transition: background-color 0.1s ease;
}

.multiple-select-option:hover,
.multiple-select-option--highlighted {
  background: #f3f4f6;
}

.multiple-select-option--selected {
  background: #f9fafb;
}

.multiple-select-option--selected:hover,
.multiple-select-option--selected.multiple-select-option--highlighted {
  background: #f3f4f6;
}

/* ── Check indicator ── */
.multiple-select-check {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 1rem;
  height: 1rem;
  border-radius: 0.25rem;
  border: 1.5px solid #d1d5db;
  flex-shrink: 0;
  transition: border-color 0.15s ease, background-color 0.15s ease;
  color: white;
  background: white;
}

.multiple-select-option--selected .multiple-select-check {
  background: #0a0a0a;
  border-color: #0a0a0a;
}

/* Check animation */
.multiple-select-check-anim-enter-active {
  transition: opacity 0.1s ease, transform 0.1s ease;
}
.multiple-select-check-anim-leave-active {
  transition: opacity 0.08s ease, transform 0.08s ease;
}
.multiple-select-check-anim-enter-from {
  opacity: 0;
  transform: scale(0.5);
}
.multiple-select-check-anim-leave-to {
  opacity: 0;
  transform: scale(0.5);
}

.multiple-select-option__label {
  flex: 1;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* ── Create option ── */
.multiple-select-option--create {
  color: #6b7280;
}

.multiple-select-create-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 1rem;
  height: 1rem;
  flex-shrink: 0;
  color: #9ca3af;
}

/* ── Actions Row ── */
.multiple-select-actions {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.5rem;
  margin-bottom: 0.125rem;
}

.multiple-select-action-btn {
  font-size: 0.75rem;
  line-height: 1rem;
  color: #6b7280;
  background: none;
  border: none;
  padding: 0;
  cursor: pointer;
  transition: color 0.15s ease;
}

.multiple-select-action-btn:hover {
  color: #0a0a0a;
}

.multiple-select-action-divider {
  color: #d1d5db;
  font-size: 0.75rem;
}

/* ── Empty State ── */
.multiple-select-empty {
  padding: 1.5rem 0.5rem;
  text-align: center;
  font-size: 0.875rem;
  color: #9ca3af;
}

/* ── Footer ── */
.multiple-select-footer {
  border-top: 1px solid #f3f4f6;
  padding: 0.375rem 0.75rem;
  flex-shrink: 0;
}

.multiple-select-footer__count {
  font-size: 0.75rem;
  color: #6b7280;
}
</style>
