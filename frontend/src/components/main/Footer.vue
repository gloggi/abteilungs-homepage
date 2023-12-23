<template>
	<div class="flex justify-center w-full background bg-[#4A4A4A]">
		<div
			class="md:w-[900px] flex flex-col md:flex-row items-start w-full px-5 md:px-0 md:justify-between py-6">
			<div>
				<h2 class="text-heading-2 text-primary text-4xl">Gruppen</h2>
				<ul class="text-white text-xl main-text space-y-1 pt-5">
					<template v-for="group in transformedGroups" :key="group.id">
						<li v-if="!group.parentId" class="pl-6">
							<router-link
								v-if="group.children.length == 0"
								:to="`/group/${group.id}`"
								>{{ group.name }}</router-link
							>
							<p v-else>{{ group.name }}</p>
							<ul
								v-if="group.children.length > 0"
								class="text-white text-xl main-text space-y-1">
								<li
									v-for="child in group.children"
									:key="child.id"
									class="pl-6">
									<router-link :to="`/group/${child.id}`">{{
										child.name
									}}</router-link>
								</li>
							</ul>
						</li>
					</template>
				</ul>
			</div>
			<div>
				<h2 class="text-heading-2 text-primary text-4xl">Links</h2>
			</div>
			<div>
				<h2 class="text-heading-2 text-primary text-4xl">Kontakt</h2>
				<div
					class="text-white"
					v-html="settings?.contactInFooter"
					v-router-link></div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			groups: [],
		};
	},
	methods: {
		async getGroups() {
			try {
				const response = await this.callApi("get", "/groups");
				this.groups = response.data.data;
			} catch (error) {
				console.log(error);
			}
		},
	},
	computed: {
		transformedGroups() {
			return this.groups.map((group) => ({
				...group,
				children: this.groups.filter((g) => g.parentId === group.id),
			}));
		},
	},
	async created() {
		await this.getGroups();
	},
};
</script>
