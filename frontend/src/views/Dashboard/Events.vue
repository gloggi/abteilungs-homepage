<template>
	<OverviewTemplate
		name="Events"
		entity="events"
		titles="Title,Start,End"
		columns="title:link(id),startTime:date,endTime:date"
		pushAfterCreationTo="Event"
		:midataSync="true" />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
	components: { OverviewTemplate },
};
</script>

<style></style>
