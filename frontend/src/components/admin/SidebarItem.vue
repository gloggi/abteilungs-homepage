<template>
  <router-link
    :to="to"
    class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-all duration-200 ease-in-out mx-2 mb-1"
    :class="[
      isActive
        ? 'bg-gray-800 text-white shadow-sm ring-1 ring-gray-700/50'
        : 'text-gray-400 hover:bg-gray-800/50 hover:text-white',
    ]"
  >
    <div class="flex h-5 w-5 items-center justify-center">
      <font-awesome-icon
        :icon="icon"
        class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"
      />
    </div>
    <span class="truncate"><slot></slot></span>
  </router-link>
</template>

<script>
export default {
  props: {
    to: String,
    icon: Object,
    exact: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    isActive() {
      if (!this.to || typeof this.to !== "string") return false;

      const currentPath = this.$route.path;

      if (this.exact) {
        return currentPath === this.to;
      }
      return currentPath === this.to || currentPath.startsWith(this.to + "/");
    },
  },
};
</script>
