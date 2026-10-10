<template>
  <ContentWrapper>
    <form
      v-if="item.form"
      :id="`form-${item.id}`"
      class="space-y-5"
      @submit.prevent="handleForm"
    >
      <HeadingTwo class="text-primary">{{ item.form.name }}</HeadingTwo>
      <div v-if="submitSuccess" class="p-5 rounded-lg bg-primary">
        <HeadingThree class="text-white font-bold">
          {{ $t("page.formSuccessMessage") }}
        </HeadingThree>
      </div>
      <div class="flex flex-col space-y-5">
        <div
          v-for="field in item.form.fields"
          :key="field.uuid"
          class="flex flex-col space-y-2"
        >
          <label class="font-bold main-text text-2xl" :for="fieldInputId(field)"
            >{{ field.label }} {{ field.required ? "*" : "" }}</label
          >
          <input
            v-if="field.type == 'textField'"
            :id="fieldInputId(field)"
            v-model="formContent[field.uuid]"
            :required="field.required"
            autocomplete="off"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary w-full"
            :type="field.inputType"
            :placeholder="field.placeholder"
          />
          <textarea
            v-if="field.type == 'textareaField'"
            :id="fieldInputId(field)"
            v-model="formContent[field.uuid]"
            :required="field.required"
            autocomplete="off"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary min-h-36"
            :placeholder="field.placeholder"
          ></textarea>
          <select
            v-if="field.type == 'selectField'"
            :id="fieldInputId(field)"
            v-model="formContent[field.uuid]"
            :required="field.required"
            class="rounded-lg border border-primary bg-white h-[50px] main-text text-xl focus:ring-0 focus:border-secondary"
          >
            <option
              v-for="option in field.optionFields"
              :key="option.uuid"
              :value="option.uuid"
            >
              {{ option.name }}
            </option>
          </select>
        </div>
      </div>
      <BasicButton v-if="!isLoading" class="w-full" type="submit">
        {{ $t("page.submit") }}
      </BasicButton>
      <BasicButton v-else class="w-full" disabled type="submit">
        <div class="flex items-center justify-center">
          <Spinner class="w-fit" />
          <div>{{ $t("page.submit") }}</div>
        </div>
      </BasicButton>
    </form>
  </ContentWrapper>
</template>
<script>
import BasicButton from "./BasicButton.vue";
import ContentWrapper from "./ContentWrapper.vue";
import HeadingTwo from "./HeadingTwo.vue";
import HeadingThree from "./HeadingThree.vue";
import Spinner from "./Spinner.vue";

export default {
  props: ["item"],
  data() {
    return {
      formContent: {},
      submitSuccess: false,
      isLoading: false,
    };
  },
  methods: {
    fieldInputId(field) {
      return `form-${this.item.id}-field-${field.uuid}`;
    },
    buildPayload() {
      return {
        id: this.item.form.id,
        fields: this.item.form.fields
          .filter((field) => field.uuid in this.formContent)
          .map((field) => ({
            uuid: field.uuid,
            value: this.formContent[field.uuid],
          })),
      };
    },
    async handleForm() {
      try {
        this.isLoading = true;
        await this.callApi("post", "/webforms", this.buildPayload());
        this.submitSuccess = true;
        document
          .getElementById(`form-${this.item.id}`)
          ?.scrollIntoView({ behavior: "smooth", block: "start" });
        this.formContent = {};
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }
    },
  },
  async created() {},
  components: {
    HeadingTwo,
    ContentWrapper,
    BasicButton,
    HeadingThree,
    Spinner,
  },
};
</script>
