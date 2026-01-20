<template>
  <ContentWrapper>
    <HeadingTwo class="w-full text-primary">{{ title }}</HeadingTwo>
    <div v-if="viewMode === 'gallery'" class="p-5 flex justify-center flex-wrap gap gap-5">
      <a
        v-for="file in files"
        :key="file.id"
        :href="`${backendURL}${file.path}`"
      >
        <div>
          <div class="flex flex-col items-center">
            <img
              :src="`${backendURL}${file.thumbnail}`"
              class="h-48 border"
              style="aspect-ratio: 1 / 1.414"
            />
            <p class="main-text text-primary">{{ file.name }}</p>
          </div>
        </div>
      </a>
    </div>
    <div v-else class="p-5 flex flex-col gap-2 max-w-2xl mx-auto">
      <a
        v-for="file in files"
        :key="file.id"
        :href="`${backendURL}${file.path}`"
        class="flex items-center gap-4 p-2 hover:bg-gray-50 rounded transition-colors group"
      >
        <div class="flex-shrink-0">
          <img
            :src="`${backendURL}${file.thumbnail}`"
            class="h-16 w-16 object-cover border rounded transition-shadow"
            style="aspect-ratio: 1 / 1.414"
          />
        </div>
        <div class="flex-grow">
          <p class="main-text font-medium group-hover:text-primary-dark">{{ file.name }}</p>
        </div>
      </a>
    </div>
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["title", "files", "viewMode"],
  data() {
    return {};
  },
  methods: {},
  async created() {},
  components: { HeadingTwo, ContentWrapper },
};
</script>
