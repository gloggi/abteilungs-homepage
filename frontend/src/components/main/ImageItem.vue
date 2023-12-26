<template>
	<div v-if="item.files.length > 1" class="relative">
		<transition name="slide">
			<img
				v-if="currentImage"
				class="w-full"
				:src="this.backendURL + currentImage" />
		</transition>
		<div
			class="absolute left-1/2 transform -translate-x-1/2 bottom-2 flex space-x-2">
			<button
				v-for="(image, i) in item.files"
				:key="i"
				class="w-6 h-2 bg-white"
				@click="changeImageTo(i)"
				:class="{ 'bg-primary': i == imageIndex % item.files.length }"></button>
		</div>
	</div>
	<div v-else>
		<img
			class="w-full"
			v-if="currentImage"
			:src="this.backendURL + currentImage" />
	</div>
</template>

<script>
export default {
	props: ["item"],
	data() {
		return {
			currentImage: undefined,
			imageIndex: 0,
		};
	},
	methods: {
		changeImage() {
			this.imageIndex++;
			this.currentImage =
				this.item.files[this.imageIndex % this.item.files.length].path;
		},
		changeImageTo(i) {
			this.currentImage = this.item.files[i].path;
			this.imageIndex = i;
		},
	},
	created() {
		this.currentImage = this.item.files[this.imageIndex]?.path;
		if (this.item.files.length > 1) {
			setInterval(this.changeImage, 5000);
		}
	},
};
</script>

<style>
/* Transition Styles */
.slide-enter-active,
.slide-leave-active {
	transition: transform 0.6s ease;
}

.slide-enter-from,
.slide-leave-to {
	transform: translateX(100%);
}

.slide-enter-to,
.slide-leave-from {
	transform: translateX(0);
}
</style>
