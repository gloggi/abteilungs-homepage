<template>
  <div>
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="camps"
      backLinkTo="Camps"
    />
    <Card class="mt-4">
      <div class="flex flex-col space-y-2" :key="loadedKey">
        <TextInput
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.description") }}</FormLabel>
          <Editor v-model="content.description" />
        </div>
        <div class="flex">
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.applicationOpeningAt") }}</FormLabel>
            {{ formatDate(content.applicationOpeningAt) }}
          </div>
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.applicationClosingAt") }}</FormLabel>
            {{ formatDate(content.applicationClosingAt) }}
          </div>
        </div>
        <div class="flex">
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.startAt") }}</FormLabel>
            {{ formatDate(content.startAt) }}
          </div>
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.finishAt") }}</FormLabel>
            {{ formatDate(content.finishAt) }}
          </div>
        </div>
        <div class="flex">
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.participantsCount") }}</FormLabel>
            {{ content.participantCount }}
          </div>
          <div class="flex flex-col space-y-2 w-full">
            <FormLabel>{{ $t("dashboard.maximumParticipants") }}</FormLabel>
            {{ content.maximumParticipants }}
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import { format } from "date-fns";
export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    Editor,
    FormLabel,
  },
  data() {
    return {
      content: {},
      errors: {},
      locations: [],
      groups: [],
      loadedKey: 0,
    };
  },
  methods: {
    async getCamp() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/camps/${this.$route.params.id}`,
        );
        this.content = response.data;
        console.log(this.content);
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updateCamp() {
      try {
        await this.callApi(
          "put",
          `/camps/${this.$route.params.id}`,
          this.content,
        );
        this.notifyUser(this.$t("dashboard.itemUpdatedMessage"));
      } catch (e) {
        console.log(e);
      }
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    formatDate(date) {
      if (!date) return "";
      return format(new Date(date), "dd.MM.yyyy HH:mm");
    },
  },
  async created() {
    await this.getCamp();
  },
};
</script>

<style></style>
