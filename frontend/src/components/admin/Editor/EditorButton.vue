<template>
	<button
		:class="`rounded-lg ${
			active ? 'bg-gray-900 text-white' : 'bg-white'
		} hover:bg-gray-900 hover:text-white border border-gray-200 p-1 text-sm`">
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: ["active"],
};
</script>

<style></style>
