<template>
	<div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
		<h2 class="font-extrabold text-4xl">{{ name }}</h2>
	</div>
	<div :class="`flex justify-between mb-2`">
		<ActionButton v-if="itemsSelected" @click="deleteItems">
			<font-awesome-icon :icon="icons.faTrash" class="h-6 w-6" />
		</ActionButton>
		<div class="w-full flex justify-end space-x-2">
			<ActionButton v-if="midataSync" @click="syncEntity">
				<MiDataSync class="h-6 w-6" />
			</ActionButton>
			<ActionButton @click="createEntity">
				<font-awesome-icon :icon="icons.faPlus" class="h-6 w-6" />
			</ActionButton>
		</div>
	</div>
	<EntityTable
		:key="tableKey"
		:entity="entity"
		@changeSelected="changeSelected"
		:titles="titles"
		:columns="columns" />
</template>

<script>
import EntityTable from "@/components/admin/EntityTable.vue";
import { faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import MiDataSync from "@/icons/MiDataSync.vue";
import ActionButton from "./ActionButton.vue";
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
	components: { EntityTable, MiDataSync, ActionButton },
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
