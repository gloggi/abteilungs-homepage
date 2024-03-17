<template>
  <div class="flex">
    <div
      class="flex flex-col justify-around items-center w-screen h-[475px] pb-[75px] px-5"
    >
      <div class="flex md:justify-end items-center w-full h-1/2 text-center">
        <img
          class="hidden md:block drop-shadow-xl max-h-full mr-5"
          :src="`${backendURL}${settings?.divisionLogo?.path}`"
        />
        <h1
          class="text-5xl md:text-6xl font-semibold text-white text-heading-1"
        >
          {{ settings.siteTitle }}
        </h1>
      </div>
      <div class="flex items-center w-full text-center">
        <h1
          class="text-5xl md:text-6xl font-semibold text-white text-heading-1"
        >
          {{ title }}
        </h1>
      </div>
    </div>
    <img
      v-if="!noImages"
      ref="currentImageRef"
      class="fixed -z-10 h-[475px] object-cover"
      :src="`${backendURL}${currentImage}`"
    />
    <img
      v-if="moreThanOneImage"
      ref="nextImageRef"
      class="fixed -z-10 h-[475px] object-cover"
      :src="`${backendURL}${nextImage}`"
    />
    <div
      v-if="noImages"
      class="fixed -z-10 h-[475px] object-cover bg-secondary"
    ></div>
  </div>
</template>
<script>
import { gsap } from "gsap";

export default {
  props: {
    title: { type: String, default: () => "" },
    images: { type: Array, default: () => [] },
  },
  data() {
    return {
      imageIndex: 0,
      currentImage: undefined,
      nextImage: undefined,
      interval: undefined,
      noImages: this.images.length === 0,
    };
  },
  methods: {
    prepareNextImage() {
      this.imageIndex = (this.imageIndex + 1) % this.images.length;
      this.nextImage = this.images[this.imageIndex].path;
      gsap.set(this.$refs.nextImageRef, { opacity: 0 });
    },
    changeImage() {
      gsap.to(this.$refs.nextImageRef, {
        opacity: 1,
        duration: 1,
        onComplete: () => {
          this.currentImage = this.nextImage;
          this.prepareNextImage();
        },
      });
    },
  },
  computed: {
    moreThanOneImage() {
      return this.images.length > 1;
    },
  },
  mounted() {
    this.currentImage = this.images[this.imageIndex]?.path;
    if (this.moreThanOneImage) {
      this.prepareNextImage();
      this.interval = setInterval(this.changeImage, 5000);
    }
  },
  beforeUnmount() {
    clearInterval(this.interval);
  },
};
</script>
