<template>
  <div>
    <div
      v-if="files && files.length > 0"
      class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6"
    >
      <MediaItem
        v-for="file in files"
        :key="file.id"
        :file="file"
        :backendURL="backendURL"
        @open="$emit('open', $event)"
        @delete="$emit('delete', $event)"
      />
    </div>
    <div
      v-else
      class="flex flex-col items-center justify-center py-16 text-center"
    >
      <div class="mb-4 rounded-full bg-gray-50 p-6">
        <font-awesome-icon :icon="faFolderOpen" class="h-8 w-8 text-gray-400" />
      </div>
      <h3 class="mt-2 text-sm font-semibold text-gray-900">
        {{ $t("dashboard.noFilesFound") }}
      </h3>
      <p class="mt-1 text-sm text-gray-500">
        {{ $t("dashboard.tryAdjustingSearch") }}
      </p>
    </div>
  </div>
</template>

<script>
import MediaItem from "./MediaItem.vue";
import { faFolderOpen } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "MediaGrid",
  components: {
    MediaItem,
    FontAwesomeIcon,
  },
  props: {
    files: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      faFolderOpen,
    };
  },
};
</script>
