<template>
  <div
    class="group relative flex flex-col rounded-xl border bg-white shadow-xs transition-all duration-200 cursor-pointer overflow-hidden"
    :class="
      selected
        ? 'border-gray-900 ring-2 ring-gray-900 ring-offset-2'
        : 'border-gray-200 hover:border-gray-300 hover:shadow-md'
    "
    @click="$emit('select', file)"
  >
    <div class="relative aspect-square w-full bg-gray-50">
      <img
        v-if="isImage(file)"
        :src="getThumbnail(file)"
        class="h-full w-full object-cover"
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
        v-if="selected"
        class="absolute inset-0 flex items-center justify-center bg-gray-900/10"
      >
        <div
          class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-900 text-white shadow-xs ring-2 ring-white"
        >
          <font-awesome-icon :icon="icons.check" class="h-4 w-4" />
        </div>
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
  faFileZipper,
  faFile,
  faCheck,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "SelectableMediaItem",
  components: {
    FontAwesomeIcon,
  },
  props: {
    file: {
      type: Object,
      required: true,
    },
    selected: {
      type: Boolean,
      default: false,
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
        check: faCheck,
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
