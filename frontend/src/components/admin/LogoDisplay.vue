<template>
  <div class="relative">
    <ColoredLogoCircle
      class="size-48"
      :src="file ? `${backendURL}${file.thumbnail}` : undefined"
      :size="size"
      :backgroundColor="backgroundColor"
      :cover="cover"
    />
    <div class="absolute top-3 right-3 flex justify-center items-center">
      <button
        @click="showModal = true"
        class="rounded-full w-7 aspect-square bg-white border"
      >
        <font-awesome-icon
          :icon="icons.faPencil"
          class="text-gray-700 h-4 w-4"
        />
      </button>
    </div>
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
