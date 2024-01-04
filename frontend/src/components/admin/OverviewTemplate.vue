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
		<button class="bg-white p-1" v-if="midataSync" @click="syncEntity">
			<MiDataSync class="h-6 w-6" />
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
import MiDataSync from "@/icons/MidataSync.vue";
export default {
	props: {
		name: String,
		entity: String,
		titles: String,
		columns: String,
		pushAfterCreationTo: String,
		midataSync: {
			type: Boolean,
			default: false,
		},
	},
	components: { Table, MiDataSync },
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
				this.notifyUser(`All selected ${this.name} were deleted`);
			} catch (e) {
				console.log(e);
			}
		},
		async syncEntity() {
			try {
				await this.callApi("post", `${this.entity}/sync`);
				this.tableKey++;
				this.notifyUser(`All ${this.name} were synced`);
			} catch (e) {
				console.log(e);
			}
		},
		async createEntity() {
			try {
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
