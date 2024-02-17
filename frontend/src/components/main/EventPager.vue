<template>
  <div class="flex items-center w-full justify-center">
    <div class="flex space-x-2">
      <template v-for="i in numberOfPages" :key="i">
        <button
          @click="changePage(i)"
          class="flex justify-center items-center rounded-full size-10 p-3 text-secondary hover:bg-white hover:border-2 hover:border-secondary"
          :class="
            currentPage === i
              ? 'bg-white border-2 border-secondary'
              : 'bg-primary'
          "
        >
          {{ i }}
        </button>
      </template>
    </div>
  </div>
</template>
<script>
export default {
  props: ["numberOfPages", "currentPage"],
  emits: ["change-page"],
  methods: {
    changePage(page) {
      this.$emit("change-page", page);
    },
  },
};
</script>
