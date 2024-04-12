<template>
  <div class="flex">
    <div
      class="flex flex-col justify-center items-center w-screen h-dvh pb-[75px]"
    >
      <div
        class="flex flex-col justify-between items-center w-full h-2/3 text-center"
      >
        <img
          class="drop-shadow-xl max-h-[50vh] md:max-h-full px-5 md:px-0"
          :src="`${backendURL}${settings?.divisionLogo?.path}`"
        />
        <h1
          class="text-5xl md:text-8xl font-semibold text-white text-heading-1"
        >
          {{ settings.siteTitle }}
        </h1>
      </div>
    </div>
    <div class="fixed -z-10 h-screen w-screen">
      <img
        ref="firstImageRef"
        v-if="firstImage"
        class="h-screen w-screen object-cover absolute z-20"
        :src="`${backendURL}${firstImage}`"
      />
      <img
        ref="secondImageRef"
        v-if="secondImage"
        class="h-screen w-screen object-cover absolute z-10"
        :src="`${backendURL}${secondImage}`"
      />
      <div
        v-if="noImages"
        class="fixed -z-10 h-screen w-screen object-cover bg-secondary"
      ></div>
    </div>
  </div>
</template>

<script>
import { gsap } from "gsap";

export default {
  props: {
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
  beforeDestroy() {
    clearTimeout(this.timeout);
  },
};
</script>
