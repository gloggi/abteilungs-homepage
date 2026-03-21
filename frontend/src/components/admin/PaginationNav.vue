<template>
  <div v-if="totalPages > 1" class="flex items-center justify-center space-x-2">
    <ButtonComponent
      variant="outline"
      size="icon"
      :disabled="pageNumber <= 1"
      @click="$emit('goToPage', pageNumber - 1)"
      class="h-9! w-9!"
    >
      <font-awesome-icon :icon="icons.faChevronLeft" class="h-4 w-4" />
      <span class="sr-only">Previous Page</span>
    </ButtonComponent>

    <template v-for="(page, index) in displayedPages" :key="index">
      <ButtonComponent
        v-if="page === '...'"
        variant="ghost"
        size="icon"
        disabled
        class="h-9! w-9!"
      >
        <font-awesome-icon :icon="icons.faEllipsis" class="h-4 w-4" />
        <span class="sr-only">More pages</span>
      </ButtonComponent>

      <ButtonComponent
        v-else
        :variant="pageNumber === page ? 'default' : 'outline-solid'"
        size="icon"
        @click="$emit('goToPage', page)"
        class="h-9! w-9!"
      >
        {{ page }}
      </ButtonComponent>
    </template>

    <ButtonComponent
      variant="outline"
      size="icon"
      :disabled="pageNumber >= totalPages"
      @click="$emit('goToPage', pageNumber + 1)"
      class="h-9! w-9!"
    >
      <font-awesome-icon :icon="icons.faChevronRight" class="h-4 w-4" />
      <span class="sr-only">Next Page</span>
    </ButtonComponent>
  </div>
</template>

<script>
import ButtonComponent from "./ButtonComponent.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faChevronLeft,
  faChevronRight,
  faEllipsis,
} from "@fortawesome/free-solid-svg-icons";

export default {
  components: {
    ButtonComponent,
    FontAwesomeIcon,
  },
  props: ["totalItems", "itemsPerPage", "pageNumber"],
  emits: ["goToPage"],
  data() {
    return {
      icons: {
        faChevronLeft,
        faChevronRight,
        faEllipsis,
      },
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    },
    displayedPages() {
      const total = this.totalPages;
      const current = this.pageNumber;
      const pages = [];

      if (total <= 7) {
        for (let i = 1; i <= total; i++) {
          pages.push(i);
        }
      } else {
        if (current <= 4) {
          for (let i = 1; i <= 5; i++) {
            pages.push(i);
          }
          pages.push("...");
          pages.push(total);
        } else if (current >= total - 3) {
          pages.push(1);
          pages.push("...");
          for (let i = total - 4; i <= total; i++) {
            pages.push(i);
          }
        } else {
          pages.push(1);
          pages.push("...");
          pages.push(current - 1);
          pages.push(current);
          pages.push(current + 1);
          pages.push("...");
          pages.push(total);
        }
      }
      return pages;
    },
  },
};
</script>

<style></style>
