<template>
	<div v-if="content">
		<ItemHeaderTemplate
			:title="content.nickname"
			:content="content"
			entity="users"
			backLinkTo="Users" />
		<Card class="mt-4">
			<div class="flex flex-col space-y-2">
				<TextInput label="Nickname" type="text" v-model="content.nickname" />
				<TextInput label="First Name" type="text" v-model="content.firstname" />
				<TextInput label="Last Name" type="text" v-model="content.lastname" />
				<MultipleSelect label="Groups" v-model="content.groups" :options="groups" />
				<SelectComponent
					label="Role"
					selection="Role"
					@selectRole="handleSelectRole"
					:options="roles"
					:value="content.role" />
			</div>
		</Card>
	</div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import {
	faArrowsRotate,
	faChevronLeft,
	faTrash,
	faPlus,
} from "@fortawesome/free-solid-svg-icons";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
export default {
	components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    MultipleSelect,
    SelectComponent
},
	data() {
		return {
			content: undefined,
			roles: [
				{ id: 1, name: "Admin" },
				{ id: 2, name: "Einheitsleiter" },
			],
			groups: [],
			icons: {
				faArrowsRotate,
				faChevronLeft,
				faTrash,
				faPlus,
			},
		};
	},
	methods: {
		async getUser() {
			try {
				const response = await this.callApi(
					"get",
					`/users/${this.$route.params.id}`,
				);
				this.content = response.data;
				this.content.groups = this.content.groups.map((group) => group.id);
				this.loadedKey++;
			} catch (e) {
				console.log(e);
			}
		},
		async updateUser() {
			try {
				await this.callApi(
					"put",
					`/users/${this.$route.params.id}`,
					this.content,
				);
			} catch (e) {
				console.log(e);
			}
		},
		async getGroups() {
			try {
				const response = await this.callApi("get", "/groups");
				this.groups = response.data.data;
			} catch (e) {
				console.log(e);
			}
		},
		handleSelectRole(role) {
			this.content.role = role;
		},
	},
	async created() {
		await this.getGroups();
		this.getUser();
	},
};
</script>

<style></style>
