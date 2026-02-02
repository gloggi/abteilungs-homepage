<template>
  <div class="group relative inline-block">
    <ColoredLogoCircle
      class="size-48 transition-all duration-300 group-hover:brightness-95"
      :src="file ? `${backendURL}${file.thumbnail}` : undefined"
      :size="size"
      :backgroundColor="backgroundColor"
      :cover="cover"
    />
    <button
      @click="showModal = true"
      class="absolute bottom-1 right-1 flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white shadow-md transition-all hover:scale-110 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
    >
      <font-awesome-icon :icon="icons.faPencil" class="h-4 w-4 text-gray-600" />
    </button>
  </div>
  <MediaModal
    v-if="showModal"
    :pre-selected="[logo]"
    :extensions="allowedExtensions"
    @close="closeHandler"
    @select="selectHandler"
    :max-select="1"
  />
</template>
<script>
import MediaModal from "../../components/admin/MediaModal.vue";
import { faPencil } from "@fortawesome/free-solid-svg-icons";
import ColoredLogoCircle from "./ColoredLogoCircle.vue";
export default {
  components: { MediaModal, ColoredLogoCircle },
  emits: ["selectImage"],
  props: {
    logo: {
      type: Object,
      default: undefined,
    },
    objectContain: {
      type: Boolean,
      default: false,
    },
    size: {
      type: Number,
      default: 100,
    },
    backgroundColor: {
      type: String,
      default: "#e5e7eb",
    },
    allowedExtensions: {
      type: Array,
      default: () => [
        "png",
        "jpeg",
        "jpg",
        "gif",
        "svg",
        "bmp",
        "webp",
        "tiff",
        "ico",
      ],
    },
    cover: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showModal: false,
      fileId: undefined,
      file: undefined,
      icons: {
        faPencil,
      },
    };
  },
  methods: {
    closeHandler() {
      this.showModal = false;
    },
    async selectHandler(selected) {
      if (selected.length > 0) {
        const file = selected[0];
        this.file = file;
      } else {
        this.file = undefined;
      }
      this.$emit("selectImage", this.file);
    },
  },
  created() {
    this.file = this.logo;
  },
};
</script>
