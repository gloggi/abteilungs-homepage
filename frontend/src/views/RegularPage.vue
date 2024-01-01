<template>
	<BigHeader v-if="page.bigHeader" :images="page.files" />
	<SmallHeader v-else :title="page.title" :images="page.files" />
	<slot name="navbar"></slot>
	<PageBuilder :page="page" />
</template>
<script>
import BigHeader from "../components/main/BigHeader.vue";
import PageBuilder from "../components/main/PageBuilder.vue";
import SmallHeader from "../components/main/SmallHeader.vue";

export default {
	components: {
		BigHeader,
		PageBuilder,
		SmallHeader,
	},
	props: {
		page: { type: Object, required: true },
	},
};
</script>
<style></style>
