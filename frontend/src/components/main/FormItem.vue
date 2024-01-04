<template>
	<ContentWrapper>
		<form class="space-y-5" @submit.prevent="handleForm">
			<HeadingOne class="text-primary">{{ item.form.name }}</HeadingOne>

			<div class="flex flex-col space-y-5 pl-4">
				<input type="text" tabindex="-1" class="absolute -left-3/4" />
				<div
					v-for="field in item.form.fields"
					:key="field.id"
					class="flex flex-col space-y-2">
					<label class="font-bold main-text text-2xl" for="form.label"
						>{{ field.label }} {{ field.required ? "*" : "" }}</label
					>
					<input
						v-if="field.type == 'textField'"
						v-model="formContent[field.key]"
						:required="field.required"
						class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary"
						:type="field.inputType"
						:placeholder="field.placeholder" />
					<textarea
						v-if="field.type == 'textareaField'"
						v-model="formContent[field.key]"
						:required="field.required"
						rows="3"
						class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary"
						:placeholder="field.placeholder"></textarea>
					<select
						v-if="field.type == 'selectField'"
						v-model="formContent[field.key]"
						:required="field.required"
						class="border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary">
						<option
							v-for="option in field.optionFields"
							:key="option.id"
							:value="option.name">
							{{ option.name }}
						</option>
					</select>
				</div>
			</div>
			<button
				type="submit"
				class="bg-primary text-white rounded-lg p-5 hover:bg-secondary w-fit main-text">
				Absenden
			</button>
		</form>
	</ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingOne from "./HeadingOne.vue";

export default {
	props: ["item"],
	data() {
		return {
			formContent: {},
		};
	},
	methods: {
		async handleForm() {
			try {
				this.formContent.id = this.item.form.id;
				const response = await this.callApi(
					"post",
					"/webforms",
					this.formContent,
				);
				console.log(response);
			} catch (error) {
				console.log(error);
			}
		},
	},
	async created() {},
	components: { HeadingOne, ContentWrapper },
};
</script>
