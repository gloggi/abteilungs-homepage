<template>
	<div>
		<ItemHeaderTemplate
			:title="content.title"
			:dublicate="true"
			:content="content"
			@errors="handleErrors"
			@clearErrors="errors = {}"
			entity="events"
			backLinkTo="Events" />
		<Card class="mt-4">
			<div class="flex flex-col space-y-2">
				<TextInput
					label="Title"
					type="text"
					v-model="content.title"
					:errors="errors.title" />
				<TextInput
					label="Start"
					type="datetime-local"
					v-model="content.startTime"
					:errors="errors.startTime" />
				<TextInput
					label="End"
					type="datetime-local"
					v-model="content.endTime"
					:errors="errors.endTime" />
				<MultipleSelect
					label="Groups"
					v-model="content.groups"
					:options="groups" />
				<Select
					label="Start Location"
					selection="StartLocation"
					@selectStartLocation="handleSelectStartLocation"
					:options="locations"
					:value="content.startLocationId"
					:errors="errors.startLocationId" />
				<Select
					label="End Location"
					selection="EndLocation"
					@selectEndLocation="handleSelectEndLocation"
					:options="locations"
					:value="content.endLocationId"
					:errors="errors.endLocationId" />
				<div class="flex flex-col space-y-2">
					<FormLabel>Description</FormLabel>
					<Editor v-model="content.description" />
				</div>
				<div class="flex flex-col space-y-2">
					<FormLabel>Take with you</FormLabel>
					<Editor v-model="content.takeWithYou" />
				</div>
			</div>
		</Card>
	</div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Select from "../../components/admin/Select.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import {
	faArrowsRotate,
	faChevronLeft,
	faTrash,
	faPlus,
} from "@fortawesome/free-solid-svg-icons";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
export default {
	components: {
		Card,
		TextInput,
		Select,
		ItemHeaderTemplate,
		FormLabel,
		Editor,
		MultipleSelect,
	},
	data() {
		return {
			content: {},
			errors: {},
			icons: {
				faArrowsRotate,
				faChevronLeft,
				faTrash,
				faPlus,
			},
			locations: [],
			groups: [],
		};
	},
	methods: {
		async getEvent() {
			if (this.$route.params.id === "new") {
				return;
			}
			try {
				const response = await this.callApi(
					"get",
					`/events/${this.$route.params.id}`,
				);
				this.content = response.data;
				if (this.content.groups) {
					this.content.groups = this.content.groups.map((g) => g.id);
				}
				this.loadedKey++;
			} catch (e) {
				console.log(e);
			}
		},
		async updateEvent() {
			try {
				await this.callApi(
					"put",
					`/events/${this.$route.params.id}`,
					this.content,
				);
				this.$store.dispatch(
					"notification/notify",
					"The Event was successfully updated!",
				);
			} catch (e) {
				console.log(e);
			}
		},
		selectEvent(event) {
			this.content.lat = event.lat;
			this.content.long = event.long;
		},
		async getLocations() {
			try {
				const response = await this.callApi("get", `/locations`);
				this.locations = response.data.data;
			} catch (e) {
				console.log(e);
			}
		},
		async getGroups() {
			try {
				const response = await this.callApi("get", `/groups`);
				this.groups = response.data.data;
			} catch (e) {
				console.log(e);
			}
		},
		handleSelectStartLocation(event) {
			this.content.startLocationId = event;
		},
		handleSelectEndLocation(event) {
			this.content.endLocationId = event;
		},
		handleSelectGroup(event) {
			this.content.groupId = event;
		},
		handleErrors(errors) {
			this.errors = errors;
		},
	},
	async created() {
		await this.getEvent();
		await this.getLocations();
		await this.getGroups();
	},
};
</script>

<style></style>