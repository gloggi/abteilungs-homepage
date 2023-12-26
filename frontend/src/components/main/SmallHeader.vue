<template>
	<div class="flex">
		<div
			class="flex flex-col justify-center items-center w-screen h-[400px] pb-[75px] px-5">
			<div class="flex md:justify-end items-center w-full h-2/3 text-center">
				<img
					class="hidden md:block drop-shadow-xl max-h-full"
					:src="`${backendURL}${settings?.divisionLogo?.path}`" />
				<h1
					class="text-5xl md:text-6xl font-semibold text-white text-heading-1">
					{{ settings.siteTitle }}
				</h1>
			</div>
			<div class="flex items-center w-full h-2/3 text-center">
				<h1
					class="text-5xl md:text-6xl font-semibold text-white text-heading-1">
					{{ page.title }}
				</h1>
			</div>
		</div>
		<img
			ref="currentImageRef"
			class="fixed -z-10 h-screen w-screen object-cover"
			:src="`${backendURL}${currentImage}`" />
		<img
			ref="nextImageRef"
			class="fixed -z-10 h-screen w-screen object-cover"
			:src="`${backendURL}${nextImage}`" />
	</div>
</template>
<script>
import { gsap } from "gsap";

export default {
	props: ["page"],
	data() {
		return {
			imageIndex: 0,
			currentImage: undefined,
			nextImage: undefined,
			interval: undefined,
		};
	},
	methods: {
		prepareNextImage() {
			this.imageIndex = (this.imageIndex + 1) % this.page.files.length;
			this.nextImage = this.page.files[this.imageIndex].path;
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
			return this.page.files.length > 1;
		},
	},
	mounted() {
		this.currentImage = this.page.files[this.imageIndex]?.path;
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
