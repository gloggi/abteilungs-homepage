<template>
	<Card v-if="user" class="text-4xl font-extrabold"
		>Hello, {{ user.nickname }}!</Card
	>
	<Button class="mt-2" @click="notify">Notification Test</Button>
</template>

<script>
import Button from "../../components/admin/Button.vue";
import Card from "../../components/admin/Card.vue";
export default {
	components: { Card, Button },
	computed: {
		user() {
			return this.$store.state.user.user;
		},
	},
	methods: {
		notify() {
			this.notifyUser("This is a test Message");
		},
	},
};
</script>

<style></style>
