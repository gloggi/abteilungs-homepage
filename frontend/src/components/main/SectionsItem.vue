<template>
  <div v-for="section in sections" :key="section.id" class="space-y-5">
    <ImageItem class="mb-3" v-if="section.files.length > 0" :item="section" />
    <ContentWrapper>
      <HeadingTwo class="text-primary">{{ section.name }}</HeadingTwo>
      <div
        v-if="section.file"
        class="float-right rounded-full size-[150px] md:size-[200px] flex justify-center items-center"
        :style="`background-color: ${section.color}`"
      >
        <img
          :src="backendURL + section.file?.path"
          class="w-[60%] h-[60%]"
        />
      </div>
      <div v-html="section.description" v-router-link></div>
    </ContentWrapper>
  </div>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingTwo from "./HeadingTwo.vue";
import ImageItem from "./ImageItem.vue";

export default {
  props: ["item"],
  data() {
    return {};
  },
  computed: {
    sections() {
      return this.$store.state.sections.sections;
    },
  },
  methods: {
    getSections() {
      this.$store.dispatch("sections/fetchSections");
    },
  },
  async created() {
    this.getSections();
  },
  components: { ImageItem, HeadingTwo, ContentWrapper },
};
</script>
