<template>
	<router-link :to="to">
		<div
			class="p-1 flex rounded-lg transition-colors duration-300 ease-in-out hover:bg-gray-50 text-gray-50 hover:text-gray-900 m-0.5"
			:class="{ 'bg-gray-50 text-gray-900': $route.path === to }">
			<div class="px-5">
				<font-awesome-icon :icon="icon" class="h-6 w-6" />
			</div>
			<div class="text"><slot></slot></div>
		</div>
	</router-link>
</template>
<script>
export default {
	components: {},
	props: ["to", "icon"],
	data() {
		return {};
	},
	methods: {},
};
</script>
