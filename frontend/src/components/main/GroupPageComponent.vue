<template>
	<PageWrapper v-if="group">
		<TextItem :item="{ title: group.name, body: group.description }" />
		<FilesItem
			v-if="group.files.length > 0"
			title="Downloads"
			:files="group.files" />
		<div>
			<ContentWrapper>
			<HeadingOne class="text-primary pb-5">Anlässe</HeadingOne>
		</ContentWrapper>
			<div v-if="events.length > 0">
				<Event
					v-for="(event, idx) in events"
					:open="idx === 0"
					:key="event.id"
					:event="event" />
			</div>
		</div>
	</PageWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import Event from "./Event.vue";
import FilesItem from "./FilesItem.vue";
import HeadingOne from "./HeadingOne.vue";
import PageWrapper from "./PageWrapper.vue";
import TextItem from "./TextItem.vue";

export default {
	props: ["group"],
	data() {
		return {
			events: [],
		};
	},
	methods: {
		async getEvents() {
			try {
				const response = await this.callApi(
					"get",
					"/events",
					{},
					{ params: { group_id: this.group.id } },
				);
				this.events = response.data.data;
			} catch (error) {
				console.log(error);
			}
		},
	},
	async created() {
		this.getEvents();
	},
	components: { PageWrapper, TextItem, Event, HeadingOne, FilesItem, ContentWrapper },
};
</script>
