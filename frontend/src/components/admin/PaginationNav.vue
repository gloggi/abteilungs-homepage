<template>
	<div
		v-if="Math.ceil(totalItems / itemsPerPage) > 1"
		class="flex rounded-b-lg p-3 bg-white"
		:key="paginationKey">
		<div class="flex justify-center w-full border-t border-gray-200">
			<button
				v-for="i in Math.ceil(totalItems / itemsPerPage)"
				@click="$emit('goToPage', i)"
				:class="`p-3  ${
					pageNumber === i
						? 'border-t-2 border-gray-900 text-gray-900'
						: 'text-gray-500'
				} `"
				:key="i">
				{{ i }}
			</button>
		</div>
	</div>
</template>

<script>
export default {
	props: ["totalItems", "itemsPerPage", "pageNumber"],
	emits: ["goToPage"],
};
</script>

<style></style>
