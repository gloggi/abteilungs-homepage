<template>
	<div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
		<h2 class="font-extrabold text-4xl">Menu & Footer Links</h2>
	</div>
	<div class="bg-gray-50 rounded-lg p-3">
		<MenuPicker />
	</div>
</template>
<script>
import MenuPicker from "../../components/admin/MenuPicker.vue";

export default {
	components: { MenuPicker },
	data() {
		return {};
	},
};
</script>
