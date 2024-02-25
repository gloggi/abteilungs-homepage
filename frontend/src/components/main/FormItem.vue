<template>
  <ContentWrapper>
    <form class="space-y-5" @submit.prevent="handleForm">
      <HeadingOne class="text-primary">{{ item.form.name }}</HeadingOne>
      <div v-if="submitSuccess" class="p-5 rounded-lg bg-primary">
        <HeadingTwo class="text-white font-bold">
          {{ $t("page.formSuccessMessage") }}
        </HeadingTwo>
      </div>

      <div class="flex flex-col space-y-5">
        <div
          v-for="field in item.form.fields"
          :key="field.id"
          class="flex flex-col space-y-2"
        >
          <label class="font-bold main-text text-2xl" for="form.label"
            >{{ field.label }} {{ field.required ? "*" : "" }}</label
          >
          <input
            v-if="field.type == 'textField'"
            v-model="formContent[field.key]"
            :required="field.required"
            autocomplete="off"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary w-full"
            :type="field.inputType"
            :placeholder="field.placeholder"
          />
          <textarea
            v-if="field.type == 'textareaField'"
            v-model="formContent[field.key]"
            :required="field.required"
            autocomplete="off"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary min-h-36"
            :placeholder="field.placeholder"
          ></textarea>
          <select
            v-if="field.type == 'selectField'"
            v-model="formContent[field.key]"
            :required="field.required"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary"
          >
            <option
              v-for="option in field.optionFields"
              :key="option.id"
              :value="option.name"
            >
              {{ option.name }}
            </option>
          </select>
        </div>
      </div>
      <BasicButton class="w-full" type="submit">
        {{ $t("page.submit") }}
      </BasicButton>
    </form>
  </ContentWrapper>
</template>
<script>
import BasicButton from "./BasicButton.vue";
import ContentWrapper from "./ContentWrapper.vue";
import HeadingOne from "./HeadingOne.vue";
import HeadingTwo from "./HeadingTwo.vue";

export default {
  props: ["item"],
  data() {
    return {
      formContent: {},
      submitSuccess: false,
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
        this.submitSuccess = true;
        this.formContent = {};
      } catch (error) {
        console.log(error);
      }
    },
  },
  async created() {},
  components: { HeadingOne, ContentWrapper, BasicButton, HeadingTwo },
};
</script>
