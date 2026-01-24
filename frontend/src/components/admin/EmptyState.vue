<template>
  <div class="flex flex-col items-center justify-center py-16 text-center">
    <div class="mb-4 rounded-full bg-gray-50 p-6">
      <font-awesome-icon :icon="icon" class="h-8 w-8 text-gray-400" />
    </div>
    <h3 class="mt-2 text-sm font-semibold text-gray-900">
      {{ title }}
    </h3>
    <p v-if="description" class="mt-1 text-sm text-gray-500">
      {{ description }}
    </p>
    <slot name="actions"></slot>
  </div>
</template>

<script>
import { faFolderOpen } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "EmptyState",
  components: {
    FontAwesomeIcon,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      default: "",
    },
    icon: {
      type: [Object, String],
      default: () => faFolderOpen,
    },
  },
};
</script>
