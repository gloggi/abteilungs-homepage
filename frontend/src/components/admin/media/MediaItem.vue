<template>
  <div
    class="group relative flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:border-gray-300 hover:shadow-md"
  >
    <div
      class="relative aspect-square w-full cursor-pointer overflow-hidden rounded-t-xl bg-gray-50"
      @click="$emit('open', file)"
    >
      <img
        v-if="isImage(file)"
        :src="getThumbnail(file)"
        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
        alt="File thumbnail"
        loading="lazy"
      />
      <div
        v-else
        class="flex h-full w-full items-center justify-center text-gray-400"
      >
        <font-awesome-icon :icon="getFileIcon(file)" class="h-12 w-12" />
      </div>

      <div
        class="absolute right-2 top-2 flex space-x-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
      >
        <button
          @click.stop="$emit('delete', file)"
          class="flex h-8 w-8 items-center justify-center rounded-md bg-white/90 text-red-500 shadow-sm backdrop-blur-sm transition-colors hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500/20"
          :title="$t('dashboard.deleteFile')"
        >
          <font-awesome-icon :icon="icons.trash" class="h-4 w-4" />
        </button>
      </div>
    </div>

    <div class="flex flex-col p-3">
      <div class="flex items-center justify-between">
        <span
          class="truncate text-sm font-medium text-gray-900"
          :title="file.name"
        >
          {{ file.name }}
        </span>
      </div>
      <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
        <span class="uppercase font-semibold tracking-wider">{{
          file.extension
        }}</span>
        <span>{{ formatFilesize(file.size) }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import {
  faFilePdf,
  faFileWord,
  faFileExcel,
  faFileImage,
  faFileAudio,
  faFileVideo,
  faFileCode,
  faFileZipper,
  faFile,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "MediaItem",
  components: {
    FontAwesomeIcon,
  },
  props: {
    file: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      icons: {
        pdf: faFilePdf,
        doc: faFileWord,
        docx: faFileWord,
        xls: faFileExcel,
        xlsx: faFileExcel,
        png: faFileImage,
        jpg: faFileImage,
        jpeg: faFileImage,
        gif: faFileImage,
        mp3: faFileAudio,
        wav: faFileAudio,
        mp4: faFileVideo,
        mov: faFileVideo,
        zip: faFileZipper,
        rar: faFileZipper,
        default: faFile,
        trash: faTrash,
      },
    };
  },
  methods: {
    isImage(file) {
      const imageTypes = new Set([
        "png",
        "jpeg",
        "jpg",
        "gif",
        "svg",
        "bmp",
        "webp",
        "tiff",
        "ico",
        "pdf",
      ]);
      return imageTypes.has(file.extension.toLowerCase());
    },
    getThumbnail(file) {
      if (!file.thumbnail) return "";
      if (file.thumbnail.startsWith("http")) return file.thumbnail;
      return `${this.backendURL}${file.thumbnail}`;
    },
    getFileIcon(file) {
      const ext = file.extension.toLowerCase();
      return this.icons[ext] || this.icons.default;
    },
    formatFilesize(size) {
      if (!size) return "";
      const i = Math.floor(Math.log(size) / Math.log(1024));
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        " " +
        ["B", "kB", "MB", "GB", "TB"][i]
      );
    },
  },
};
</script>
