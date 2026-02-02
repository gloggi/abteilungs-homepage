<template>
  <div class="flex w-full flex-col gap-1.5">
    <FormLabel v-if="label">{{ label }}</FormLabel>
    <div class="flex items-center gap-2">
      <div
        class="flex h-10 w-full items-center overflow-hidden rounded-md border border-gray-200 bg-white text-sm ring-offset-white focus-within:ring-2 focus-within:ring-gray-950 focus-within:ring-offset-2"
        @click="!isEditing && startEditing()"
        :class="{ 'cursor-text': !isEditing }"
      >
        <span
          class="flex h-full select-none items-center border-r border-gray-100 bg-gray-50 px-3 text-gray-500"
        >
          {{ prefix }}
        </span>
        <input
          v-if="isEditing"
          :id="id"
          ref="input"
          type="text"
          class="flex-1 bg-transparent px-3 py-2 placeholder:text-gray-500 focus:outline-none"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          @keyup.enter="save"
        />
        <span v-else class="flex-1 truncate px-3 py-2 text-gray-900">
          {{ modelValue }}
        </span>
      </div>
      <ActionButton
        v-if="isEditing"
        @click="save"
        size="icon"
        variant="outline"
      >
        <font-awesome-icon :icon="icons.faCheck" class="size-4" />
      </ActionButton>
      <ActionButton
        v-else
        @click="startEditing"
        size="icon"
        variant="outline"
        :toolTipText="toolTipText"
      >
        <font-awesome-icon :icon="icons.faPen" class="size-4" />
      </ActionButton>
    </div>
    <div v-if="errors" class="text-xs text-red-500">
      {{ Array.isArray(errors) ? errors.join(" ") : errors }}
    </div>
  </div>
</template>

<script>
import FormLabel from "./FormLabel.vue";
import ActionButton from "./ActionButton.vue";
import { faPen, faCheck } from "@fortawesome/free-solid-svg-icons";

export default {
  components: {
    FormLabel,
    ActionButton,
  },
  props: {
    modelValue: {
      type: String,
      default: "",
    },
    errors: {
      type: [Array, String],
      default: null,
    },
    prefix: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      default: "slug",
    },
    toolTipText: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      isEditing: false,
      icons: {
        faPen,
        faCheck,
      },
    };
  },
  methods: {
    startEditing() {
      this.isEditing = true;
      this.$nextTick(() => {
        if (this.$refs.input) {
          this.$refs.input.focus();
        }
      });
    },
    save() {
      this.isEditing = false;
    },
    cancelEditing() {
      this.isEditing = false;
    },
  },
};
</script>
