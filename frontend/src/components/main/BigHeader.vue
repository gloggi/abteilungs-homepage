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
        ref="currentImageRef"
        v-if="currentImage"
        class="h-screen w-screen object-cover absolute"
        :src="`${backendURL}${currentImage}`"
      />
      <img
        ref="nextImageRef"
        v-if="nextImage"
        class="h-screen w-screen object-cover absolute"
        :src="`${backendURL}${nextImage}`"
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
  props: { images: { type: Array, default: () => [] } },
  data() {
    return {
      imageIndex: 0,
      currentImage: undefined,
      nextImage: undefined,
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
        duration: 0.7,
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
      setInterval(this.changeImage, 5000);
    }
  },
};
</script>
