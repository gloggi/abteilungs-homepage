<template>
  <div class="w-full">
    <div v-if="loading" class="flex justify-center items-center py-12">
      <div
        class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"
      ></div>
    </div>

    <div
      v-else-if="content && content.length > 0"
      class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 w-full"
      :key="listKey"
    >
      <SelectableMediaItem
        v-for="file in content"
        :key="file.id"
        :file="file"
        :selected="isItemIncluded(file)"
        @select="selectItem"
      />
    </div>

    <div
      v-else
      class="flex flex-col items-center justify-center py-16 text-center w-full"
    >
      <div class="mb-4 rounded-full bg-gray-50 p-6">
        <font-awesome-icon
          :icon="icons.folderOpen"
          class="h-8 w-8 text-gray-400"
        />
      </div>
      <h3 class="mt-2 text-sm font-semibold text-gray-900">
        {{ $t("dashboard.noFilesFound") }}
      </h3>
    </div>
  </div>
</template>
<script>
import SelectableMediaItem from "./media/SelectableMediaItem.vue";
import { faFolderOpen } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  components: { SelectableMediaItem, FontAwesomeIcon },
  props: {
    category: {
      type: String,
      default: "general",
    },
    maxSelect: {
      type: Number,
      default: 1,
    },
    preSelected: {
      type: Array,
      default: () => [],
    },
    extensions: {
      type: Array,
      default: () => [],
    },
  },
  emits: ["selectItems"],
  data() {
    return {
      content: undefined,
      listKey: 0,
      items: [],
      icons: {
        folderOpen: faFolderOpen,
      },
      loading: false,
    };
  },
  methods: {
    isItemIncluded(item) {
      return !!this.items.find((i) => i?.id == item.id);
    },
    async getMedia() {
      this.loading = true;
      try {
        const response = await this.callApi(
          "get",
          "/files",
          {},
          { params: { extensions: this.extensions.join(","), per_page: 100 } },
        );
        this.content = response.data.data;
        this.listKey++;
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    selectItem(item) {
      if (this.items.map((i) => i?.id).includes(item.id)) {
        this.items = this.items.filter((i) => i.id !== item.id);
        this.$emit("selectItems", [...this.items]);
        return;
      } else if (this.items.length == this.maxSelect) {
        this.items.shift();
        this.items.push(item);
      } else {
        this.items.push(item);
      }
      this.$emit("selectItems", this.items);
    },
  },
  async created() {
    await this.getMedia();
    this.items = [...this.preSelected];
  },
};
</script>
