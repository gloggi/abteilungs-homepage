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
          id="name"
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
        <MultipleSelect
          id="groups"
          :label="$t('dashboard.groups')"
          v-model="content.groups"
          :options="groups"
        />
        <TextInput
          id="midataLink"
          :label="$t('dashboard.midataLink')"
          type="url"
          v-model="content.externalApplicationLink"
          :errors="errors.externalApplicationLink"
        />
        <BreakPointSpaceManager>
          <TextInput
            id="applicationOpeningAt"
            :label="$t('dashboard.applicationOpeningAt')"
            type="date"
            v-model="content.applicationOpeningAt"
            :errors="errors.applicationOpeningAt"
          />
          <TextInput
            id="applicationClosingAt"
            :label="$t('dashboard.applicationClosingAt')"
            type="date"
            v-model="content.applicationClosingAt"
            :errors="errors.applicationClosingAt"
          />
        </BreakPointSpaceManager>
        <BreakPointSpaceManager>
          <TextInput
            id="startAt"
            :label="$t('dashboard.startAt')"
            type="datetime-local"
            v-model="content.startAt"
            :errors="errors.startAt"
          />
          <TextInput
            id="finishAt"
            :label="$t('dashboard.finishAt')"
            type="datetime-local"
            v-model="content.finishAt"
            :errors="errors.finishAt"
          />
        </BreakPointSpaceManager>
        <BreakPointSpaceManager>
          <TextInput
            id="participantsCount"
            :label="$t('dashboard.participantsCount')"
            type="number"
            v-model="content.participantsCount"
            :errors="errors.participantsCount"
          />
          <TextInput
            id="maximumParticipants"
            :label="$t('dashboard.maximumParticipants')"
            type="number"
            v-model="content.maximumParticipants"
            :errors="errors.maximumParticipants"
          />
        </BreakPointSpaceManager>
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.description") }}</FormLabel>
          <Editor
            v-model="content.customDescription"
            :placeholder="content.description"
          />
        </div>
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.files") }}</FormLabel>
          <FilesSelector
            :key="loadedKey"
            :item="{ files: content.files }"
            @changeFiles="changeFiles"
          />
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
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import BreakPointSpaceManager from "../../components/admin/BreakpointSpaceManager.vue";
import FilesSelector from "../../components/admin/FilesSelector.vue";
export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    Editor,
    FormLabel,
    MultipleSelect,
    BreakPointSpaceManager,
    FilesSelector,
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
        this.content.groups = this.content.groups.map((group) => group.id);
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
    getGroups() {
      this.callApi("get", "/groups").then((response) => {
        this.groups = response.data.data;
      });
    },
    changeFiles(event) {
      this.content.files = event.files;
    },
  },
  async created() {
    await this.getCamp();
    await this.getGroups();
  },
};
</script>

<style></style>
