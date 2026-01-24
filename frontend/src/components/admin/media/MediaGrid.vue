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
    <EmptyState
      v-else
      :title="$t('dashboard.noFilesFound')"
      :description="$t('dashboard.tryAdjustingSearch')"
      :icon="faFolderOpen"
    />
  </div>
</template>

<script>
import MediaItem from "./MediaItem.vue";
import EmptyState from "../EmptyState.vue";
import { faFolderOpen } from "@fortawesome/free-solid-svg-icons";


export default {
  name: "MediaGrid",
  components: {
    MediaItem,

    EmptyState,
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
