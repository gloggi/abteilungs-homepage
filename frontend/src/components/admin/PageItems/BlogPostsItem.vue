<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="$emit('delete', item)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <div class="space-y-4">
      <TagInput
        :label="$t('dashboard.tags')"
        :modelValue="item.tags || []"
        :allowCreate="false"
        @update:modelValue="updateTags"
      />
    </div>
  </DragItemBox>
</template>

<script>
import DragItemBox from "../DragItemBox.vue";
import TagInput from "../../ui/TagInput.vue";

export default {
  components: {
    DragItemBox,
    TagInput,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
    boxTitle: {
      type: String,
      default: "Blog Posts",
    },
  },
  emits: ["delete", "startedDragging", "endedDragging", "changeBlogPostsItem"],
  data() {
    return {};
  },
  computed: {
    selectedBlogPosts() {
      return this.item.blog_posts || [];
    },
  },
  methods: {
    updateTags(tags) {
      this.emitChange({ ...this.item, tags: tags, view_mode: "selected" });
    },
    emitChange(newItem) {
      this.$emit("changeBlogPostsItem", newItem);
    },
  },
};
</script>
