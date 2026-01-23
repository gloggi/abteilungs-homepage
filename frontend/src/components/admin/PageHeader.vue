<template>
  <div
    class="mb-8 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center"
  >
    <div>
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        {{ title }}
      </h1>
      <p v-if="description" class="mt-1 text-sm text-gray-500">
        {{ description }}
      </p>
    </div>
    <div class="w-full md:w-auto flex flex-wrap gap-2 items-center">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "PageHeader",
  props: {
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      default: "",
    },
  },
};
</script>
