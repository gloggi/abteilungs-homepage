<template>
	<OverviewTemplate
		name="Events"
		entity="events"
		titles="Title,Start,End"
		columns="title:link(id),startTime,endTime"
		pushAfterCreationTo="Event" />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
	components: { OverviewTemplate },
};
</script>

<style></style>
