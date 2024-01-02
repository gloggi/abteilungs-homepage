<template>
	<div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
		<h2 class="font-extrabold text-4xl">{{ name }}</h2>
	</div>
	<div
		:class="`flex ${itemsSelected ? 'justify-between' : 'justify-end'} mb-2`">
		<button
			v-if="itemsSelected"
			@click="deleteItems"
			class="bg-white p-1 rounded-l-lg">
			<font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
		</button>

		<button class="rounded-r-lg bg-white p-1" @click="createEntity">
			<font-awesome-icon :icon="icons.faPlus" class="h-6 w-6 text-gray-500" />
		</button>
	</div>
	<Table
		:key="tableKey"
		:entity="entity"
		@changeSelected="changeSelected"
		:titles="titles"
		:columns="columns" />
</template>

<script>
import Table from "@/components/admin/Table.vue";
import { faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
	props: ["name", "entity", "titles", "columns", "pushAfterCreationTo"],
	components: { Table },
	data() {
		return {
			content: undefined,
			selected: [],
			tableKey: 0,
			icons: {
				faTrash,
				faPlus,
			},
		};
	},
	computed: {
		itemsSelected() {
			return this.selected.length > 0;
		},
	},
	methods: {
		changeSelected(event) {
			this.selected = event;
		},
		async deleteItems() {
			try {
				await Promise.all(
					this.selected.map(async (entityId) => {
						await this.callApi("delete", `${this.entity}/${entityId}`);
					}),
				);
				this.selected = [];
				this.tableKey++;
				this.$store.dispatch(
					"notification/notify",
					`All selected ${this.name} were deleted`,
				);
			} catch (e) {
				console.log(e);
			}
		},
		async createEntity() {
			try {
				//const response = await this.callApi("post", `/${this.entity}`, {});
				this.$router.push({
					name: this.pushAfterCreationTo,
					params: { id: "new" },
				});
			} catch (e) {
				console.log(e);
			}
		},
	},
};
</script>

<style></style>