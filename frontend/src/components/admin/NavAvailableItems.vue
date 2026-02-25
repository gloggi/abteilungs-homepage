<template>
  <div class="flex flex-col space-y-6 pr-2">
    <div>
      <h3 class="font-semibold text-gray-900 mb-3">
        {{ $t("dashboard.customLinks") }}
      </h3>
      <div
        class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors"
        draggable="true"
        @dragstart="
          onDragStart($event, {
            type: 'customItem',
            title: 'Neuer Link',
            url: 'https://',
          })
        "
      >
        <div class="flex items-center gap-3">
          <span class="text-gray-400"
            ><font-awesome-icon :icon="icons.faLink"
          /></span>
          <span class="text-sm font-medium text-gray-700">{{
            $t("dashboard.customLinkDraggable") || "Custom Link"
          }}</span>
        </div>
      </div>
    </div>
    <div>
      <h3 class="font-semibold text-gray-900 mb-3">
        {{ $t("dashboard.specialItems") }}
      </h3>
      <div class="space-y-2">
        <div
          v-if="showGroupPagesItem"
          class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors flex items-center gap-3"
          draggable="true"
          @dragstart="
            onDragStart($event, {
              special: 'groupPages',
              title: $t('dashboard.groupPagesDropdown'),
            })
          "
        >
          <span class="text-gray-400"
            ><font-awesome-icon :icon="icons.faLayerGroup"
          /></span>
          <span class="text-sm font-medium text-gray-700">{{
            $t("dashboard.groupPagesDropdown")
          }}</span>
        </div>
        <div
          v-if="showBlogOverviewItem"
          class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors flex items-center gap-3"
          draggable="true"
          @dragstart="
            onDragStart($event, {
              special: 'blogOverview',
              title: $t('dashboard.blogOverview'),
              url: '/blog',
            })
          "
        >
          <span class="text-gray-400"
            ><font-awesome-icon :icon="icons.faNewspaper"
          /></span>
          <span class="text-sm font-medium text-gray-700">{{
            $t("dashboard.blogOverview")
          }}</span>
        </div>
      </div>
    </div>
    <div>
      <h3 class="font-semibold text-gray-900 mb-3">
        {{ $t("dashboard.pages") }}
      </h3>
      <div class="space-y-2">
        <div
          v-for="page in pages"
          :key="page.id"
          class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors flex items-center gap-3"
          draggable="true"
          @dragstart="
            onDragStart($event, {
              page_id: page.id,
              title: page.title,
              url: '/' + page.route,
            })
          "
        >
          <span class="text-gray-400"
            ><font-awesome-icon :icon="icons.faFile"
          /></span>
          <span class="text-sm font-medium text-gray-700 truncate">{{
            page.title
          }}</span>
        </div>
        <div v-if="pages.length === 0" class="text-sm text-gray-400 italic">
          {{ $t("dashboard.noPagesAvailable") || "No pages available" }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  faLink,
  faLayerGroup,
  faNewspaper,
  faFile,
} from "@fortawesome/free-solid-svg-icons";

export default {
  name: "NavAvailableItems",
  props: {
    pages: {
      type: Array,
      default: () => [],
    },
    usedSpecials: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      icons: {
        faLink,
        faLayerGroup,
        faNewspaper,
        faFile,
      },
    };
  },
  computed: {
    showGroupPagesItem() {
      return !this.usedSpecials.includes("groupPages");
    },
    showBlogOverviewItem() {
      return !this.usedSpecials.includes("blogOverview");
    },
  },
  methods: {
    onDragStart(e, item) {
      e.dataTransfer.effectAllowed = "copy";
      e.dataTransfer.setData(
        "application/json",
        JSON.stringify({
          item: item,
          source: "available",
        }),
      );
    },
  },
};
</script>
