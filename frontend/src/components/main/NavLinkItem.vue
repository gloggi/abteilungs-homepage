<template>
	<li
		class="font-light p-3 py-5 md:py-0 md:p-0 hover:text-secondary text-white main-text md:text-2xl">
		<router-link
			v-if="menuItem.pageId"
			:to="menuItem.url"
			@click="handlePageChange"
			><slot></slot
		></router-link>
		<a v-else :href="menuItem.url"><slot></slot></a>
	</li>
</template>
<script>
export default {
	props: {
		menuItem: {
			type: Object,
			required: true,
		},
	},
	emits: ["pageChange"],
	methods: {
		handlePageChange() {
			this.$emit("pageChange", this.menuItem.pageId);
		},
	},
};
</script>
