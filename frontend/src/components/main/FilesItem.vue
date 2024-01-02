<template>
	<ContentWrapper>
		<HeadingOne class="w-full text-primary">{{ title }}</HeadingOne>
		<div class="p-5 flex justify-center flex-wrap gap gap-5">
			<a
				v-for="file in files"
				:key="file.id"
				:href="`${backendURL}${file.path}`">
				<div>
					<div class="flex flex-col items-center">
						<img
							:src="`${backendURL}${file.thumbnail}`"
							class="h-48 border"
							style="aspect-ratio: 1 / 1.414" />
						<p class="main-text text-primary">{{ file.name }}</p>
					</div>
				</div>
			</a>
		</div>
	</ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingOne from "./HeadingOne.vue";

export default {
	props: ["title", "files"],
	data() {
		return {};
	},
	methods: {},
	async created() {},
	components: { HeadingOne, ContentWrapper },
};
</script>
