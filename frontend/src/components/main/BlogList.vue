<template>
  <div>
    <div class="grid gap-8">
      <BlogItem v-for="post in posts" :key="post.id" :post="post" />
    </div>

    <div
      v-if="posts.length === 0 && !isLoading"
      class="text-center italic text-gray-500"
    >
      {{ $t("blog.noPosts") }}
    </div>

    <Pager
      class="mt-4"
      v-if="pagination && pagination.lastPage > 1"
      :numberOfPages="pagination.lastPage"
      :currentPage="pagination.currentPage"
      @change-page="handlePageChange"
    />
  </div>
</template>

<script>
import BlogItem from "./BlogItem.vue";
import Pager from "./Pager.vue";

export default {
  name: "BlogList",
  components: {
    BlogItem,
    Pager,
  },
  props: {
    limit: {
      type: Number,
      default: 6,
    },
    endpoint: {
      type: String,
      default: "/blogposts",
    },
  },
  data() {
    return {
      posts: [],
      pagination: {},
      isLoading: false,
    };
  },
  mounted() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts(page = 1) {
      this.isLoading = true;
      try {
        const { data } = await this.callApi(
          "get",
          this.endpoint,
          {},
          {
            params: {
              page: page,
              per_page: this.limit,
            },
          },
        );
        this.posts = data.data || [];
        this.pagination = data;
      } catch (error) {
        console.error("BlogList fetch failed", error);
      } finally {
        this.isLoading = false;
      }
    },
    handlePageChange(page) {
      this.$el.scrollIntoView({ behavior: "smooth" });
      this.fetchPosts(page);
    },
  },
};
</script>
