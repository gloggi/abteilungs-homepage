<template>
	<OverviewTemplate
		name="Camps"
		entity="camps"
		titles="Name,Start Date,End Date,Participants"
		columns="name:link(id),startAt:date,finishAt:date,participantCount"
		pushAfterCreationTo="Camp"
		:midataSync="true" />
</template>

<script>
import OverviewTemplate from "../../components/admin/OverviewTemplate.vue";

export default {
	components: { OverviewTemplate },
};
</script>

<style></style>
