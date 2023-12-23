<template>
	<ContentWrapper>
		<FleurDeLis class="hidden md:flex" v-if="item.showFleurDeLis" />
		<HeadingOne class="text-primary">{{ item.title }}</HeadingOne>
		<div v-html="item.body" v-router-link></div>
	</ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import FleurDeLis from "./FleurDeLis.vue";
import HeadingOne from "./HeadingOne.vue";

export default {
	props: ["item"],
	data() {
		return {};
	},
	methods: {},
	async created() {},
	components: { HeadingOne, FleurDeLis, ContentWrapper },
};
</script>
