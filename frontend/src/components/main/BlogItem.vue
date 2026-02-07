<template>
  <div
    class="group h-full flex flex-col bg-white border border-primary rounded-xl overflow-hidden"
  >
    <div class="flex-1 p-0 flex flex-col">
      <div
        v-if="displayImage"
        class="h-48 w-full overflow-hidden border-b border-gray-100"
      >
        <img
          :src="`${backendURL}${displayImage.path}`"
          class="w-full h-full object-cover object-center"
          alt=""
        />
      </div>
      <div class="p-6 flex-1 flex flex-col">
        <div class="flex items-center justify-start mb-4">
          <span class="main-text text-md text-primary flex items-center">
            {{ formattedDate }}
          </span>
        </div>

        <router-link
          :to="{ name: 'PublicBlogPost', params: { slug: post.slug } }"
          class="block mb-3"
        >
          <HeadingThree class="text-primary">
            {{ post.title }}
          </HeadingThree>
        </router-link>

        <div class="main-text">
          {{ previewText }}
        </div>
        <div class="mt-auto pt-4">
          <router-link
            :to="{ name: 'PublicBlogPost', params: { slug: post.slug } }"
          >
            <BasicButton>
              {{ $t("blog.readMore") }}
            </BasicButton>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BasicButton from "./BasicButton.vue";
import HeadingThree from "./HeadingThree.vue";

export default {
  name: "BlogItem",
  components: {
    HeadingThree,
    BasicButton,
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  computed: {
    formattedDate() {
      if (!this.post.publishedAt) return "";
      const date = this.post.publishedAt;
      return new Date(date).toLocaleDateString(navigator.language || "de-CH", {
        day: "numeric",
        month: "long",
        year: "numeric",
      });
    },
    previewText() {
      const items = this.post.textItems || this.post.text_items || [];

      if (!items || items.length === 0) {
        return "";
      }

      const sortedItems = [...items].sort(
        (a, b) => (a.sort || 0) - (b.sort || 0),
      );

      const firstItem = sortedItems[0];

      if (!firstItem || !firstItem.body) return "";

      const tmp = firstItem.body.replace(/<[^>]*>?/gm, "");
      return tmp;
    },
    displayImage() {
      if (this.post.previewImage) {
        return this.post.previewImage;
      }
      if (this.post.files && this.post.files.length > 0) {
        return this.post.files[0];
      }
      return null;
    },
  },
};
</script>
