<template>
	<div class="">
		<FormLabel>
			{{ label }}
		</FormLabel>
		<textarea
			rows="7"
			v-model="payload"
			class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
			:id="label"
			:type="type"
			:placeholder="label"
			:disabled="disabled"></textarea>
	</div>
</template>

<script>
import { computed } from "vue";
import FormLabel from "./FormLabel.vue";
export default {
	props: ["label", "type", "content", "modelValue", "disabled"],
	setup(props, { emit }) {
		const payload = computed({
			get: () => props.modelValue,
			set: (value) => emit("update:modelValue", value),
		});
		return {
			payload,
		};
	},
	components: { FormLabel },
};
</script>

<style></style>
