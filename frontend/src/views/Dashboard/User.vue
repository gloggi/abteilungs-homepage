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
export default {
	components: {
		Card,
		TextInput,
		ItemHeaderTemplate,
	},
	data() {
		return {
			content: undefined,
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
	},
	created() {
		this.getUser();
	},
};
</script>

<style></style>
