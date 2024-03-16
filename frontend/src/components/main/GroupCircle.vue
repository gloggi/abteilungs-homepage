<template>
  <div
    @click="$emit('select-group', group)"
    class="relative cursor-pointer rounded-full aspect-square w-[100px] md:w-[150px] flex justify-center items-center"
    :style="`background-color: ${group.color}`"
  >
    <div
      class="absolute top-0 right-0 rounded-full size-6 md:size-10 bg-secondary flex justify-center items-center"
    >
      <img :src="genderIcon" class="w-[65%] h-[65%]" />
    </div>
    <img
      v-if="group.file?.path"
      :src="backendURL + group.file?.path"
      class="w-[60%] h-[60%]"
    />
  </div>
</template>
<script>
export default {
  props: {
    group: {
      type: Object,
      required: true,
    },
    genderIcon: {
      type: String,
      required: false,
    },
  },
};
</script>
