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
      ref="firstImageRef"
      v-if="firstImage"
      class="h-[475px] w-full object-cover fixed -z-10"
      :src="`${backendURL}${firstImage}`"
    />
    <img
      ref="secondImageRef"
      v-if="secondImage"
      class="h-[475px] w-full object-cover fixed -z-20"
      :src="`${backendURL}${secondImage}`"
    />
    <div
      v-if="noImages"
      class="fixed -z-10 h-[475px] w-full object-cover bg-secondary"
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
      imageIDX: -1,
      firstImage: undefined,
      secondImage: undefined,
      noImages: this.images.length === 0,
      animationDuration: 1,
      displayTime: 5000,
      timeout: undefined,
    };
  },
  methods: {
    getImageIndex() {
      this.imageIDX = (this.imageIDX + 1) % this.images.length;
      return this.imageIDX;
    },
    changeImage() {
      gsap.to(this.$refs.firstImageRef, {
        opacity: 0,
        duration: this.animationDuration,
        onComplete: async () => {
          await new Promise((resolve) => setTimeout(resolve, this.displayTime));
          this.firstImage = this.images[this.getImageIndex()]?.path;
          gsap.to(this.$refs.firstImageRef, {
            opacity: 1,
            duration: this.animationDuration,
            onComplete: () => {
              this.secondImage = this.images[this.getImageIndex()]?.path;
              this.timeout = setTimeout(this.changeImage, this.displayTime);
            },
          });
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
    this.firstImage = this.images[this.getImageIndex()]?.path;
    if (this.moreThanOneImage) {
      this.secondImage = this.images[this.getImageIndex()]?.path;
      this.timeout = setTimeout(this.changeImage, this.displayTime);
    }
  },
  beforeUnmount() {
    clearTimeout(this.timeout);
  },
};
</script>
