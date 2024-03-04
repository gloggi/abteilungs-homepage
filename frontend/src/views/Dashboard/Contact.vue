<template>
  <div>
    <ItemHeaderTemplate
      @errors="handleErrors"
      @clearErrors="errors = {}"
      :title="content.nickname"
      :content="content"
      entity="contacts"
      backLinkTo="Contacts"
    />
    <Card class="mt-4">
      <div
        class="flex flex-col md:flex-row space-x-0 md:space-x-5 space-y-5 items-center md:items-start md:space-y-0 h-full w-full"
      >
        <LogoDisplay
          :key="loadedKey"
          :logo="content.file"
          @selectImage="updateLogo"
        />
        <div class="space-y-2 w-full">
          <TextInput
            :label="$t('dashboard.nickname')"
            type="text"
            v-model="content.nickname"
            :errors="errors.nickname"
          />
          <BreakpointSpaceManager>
            <TextInput
              class="w-full"
              :label="$t('dashboard.firstName')"
              type="text"
              v-model="content.firstname"
              :errors="errors.firstname"
            />
            <TextInput
              class="w-full"
              :label="$t('dashboard.lastName')"
              type="text"
              v-model="content.lastname"
              :errors="errors.lastname"
            />
          </BreakpointSpaceManager>
          <TextInput
            :label="$t('dashboard.email')"
            type="email"
            v-model="content.email"
            :errors="errors.email"
          />
          <TextInput
            :label="$t('dashboard.role')"
            type="text"
            v-model="content.role"
            :errors="errors.role"
          />
          <TextInput
            :label="$t('dashboard.sort')"
            type="number"
            v-model="content.sort"
            :errors="errors.sort"
          />
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import BreakpointSpaceManager from "../../components/admin/BreakpointSpaceManager.vue";
export default {
  components: {
    Card,
    TextInput,
    LogoDisplay,
    ItemHeaderTemplate,
    BreakpointSpaceManager,
  },
  data() {
    return {
      content: {},
      sections: undefined,
      showModal: false,
      loadedKey: 0,
      errors: {},
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
      },
    };
  },
  methods: {
    updateLogo(file) {
      if (file) {
        this.content.fileId = file?.id;
      } else {
        this.content.fileId = null;
      }

      console.log("fileId", this.content.fileId);
      this.updateContact();
    },
    async getContact() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/contacts/${this.$route.params.id}`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async getSections() {
      try {
        const response = await this.callApi("get", `/sections`);
        this.sections = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    async updateContact() {
      try {
        await this.callApi(
          "put",
          `/contacts/${this.$route.params.id}`,
          this.content,
        );
        this.notifyUser(this.$t("dashboard.itemUpdatedMessage"));
      } catch (e) {
        console.log(e);
      }
    },
    handleSection(sectionId) {
      this.content.sectionId = sectionId;
    },
    handleErrors(errors) {
      this.errors = errors;
    },
  },
  async created() {
    await this.getSections();
    await this.getContact();
  },
};
</script>

<style></style>
