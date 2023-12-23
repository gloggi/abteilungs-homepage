<template>
	<DragItemBox
		:boxTitle="boxTitle"
		:item="item"
		@delete="(event) => $emit('delete', event)"
		@startedDragging="$emit('startedDragging')"
		@endedDragging="$emit('endedDragging')">
		<Card class="space-y-2">
			At this point all contacts that you have entered in the Contacts tab are
			shown.
		</Card>
	</DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import DragItemBox from "../DragItemBox.vue";

export default {
	components: { Card, DragItemBox },
	props: ["boxTitle", "item"],
	emits: ["delete", "startedDragging", "endedDragging"],
	data() {
		return {
			options: [],
		};
	},
	methods: {},

	computed: {},
	async created() {},
};
</script>

<style></style>
