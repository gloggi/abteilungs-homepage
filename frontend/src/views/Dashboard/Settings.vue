<template>
  <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
    <h2 class="font-extrabold text-4xl">{{ $t("dashboard.settings") }}</h2>
  </div>
  <div class="flex justify-end mb-2">
    <div>
      <ActionButton
        @click="updateSettings"
        :toolTipText="$t('dashboard.saveChanges')"
      >
        <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6" />
      </ActionButton>
    </div>
  </div>
  <div
    v-if="modifiableSettings"
    class="bg-gray-50 rounded-lg p-3 flex flex-col space-y-2"
  >
    <SmallTitle>{{ $t("dashboard.generalSettings") }}</SmallTitle>
    <TextInput
      id="siteTitle"
      :label="$t('dashboard.siteTitle')"
      v-model="modifiableSettings.siteTitle"
      :errors="errors.siteTitle"
    />
    <TextInput
      id="divisionName"
      :label="$t('dashboard.divisionName')"
      v-model="modifiableSettings.divisionName"
      :errors="errors.divisionName"
    />
    <div
      class="flex flex-col md:flex-row w-full md:justify-around items-center md:items-start"
    >
      <div>
        <FormLabel>{{ $t("dashboard.divisionLogo") }}</FormLabel>
        <LogoDisplay
          :allowedExtensions="['svg', 'png', 'jpg', 'jpeg', 'gif', 'webp']"
          :logo="modifiableSettings.divisionLogo"
          @selectImage="(e) => updateLogo('divisionLogo', e)"
        />
      </div>
      <div>
        <FormLabel>{{ $t("dashboard.websiteIcon") }}</FormLabel>
        <LogoDisplay
          :logo="modifiableSettings.websiteIcon"
          @selectImage="(e) => updateLogo('websiteIcon', e)"
          :allowedExtensions="['png', 'jpg', 'jpeg', 'gif', 'webp']"
        />
      </div>
      <div>
        <FormLabel>{{ $t("dashboard.socialIcon") }}</FormLabel>
        <LogoDisplay
          :logo="modifiableSettings.socialIcon"
          @selectImage="(e) => updateLogo('socialIcon', e)"
          :allowedExtensions="['png', 'jpg', 'jpeg']"
        />
        <InfoField class="w-48" :info="$t('dashboard.socialIconInfo')" />
      </div>
    </div>
    <div class="flex space-x-8">
      <div class="">
        <FormLabel>{{ $t("dashboard.primaryColor") }}</FormLabel>
        <ColorPicker v-model="modifiableSettings.primaryColor" />
      </div>
      <div class="">
        <FormLabel>{{ $t("dashboard.secondaryColor") }}</FormLabel>
        <ColorPicker v-model="modifiableSettings.secondaryColor" />
      </div>
    </div>
    <SelectComponent
      id="notFoundPage"
      selection="NotFoundPage"
      :label="$t('dashboard.notFoundPage')"
      @selectNotFoundPage="handleNotFoundPage"
      :value="modifiableSettings.notFoundPageId"
      :options="pages"
      :errors="errors.notFoundPageId"
    />
    <CheckBox
      :label="$t('dashboard.isRegion')"
      v-model="modifiableSettings.isRegion"
    />
    <SmallTitle>{{ $t("dashboard.midataSettings") }}</SmallTitle>
    <TextInput
      id="midataId"
      :label="$t('dashboard.midataId')"
      type="number"
      v-model="modifiableSettings.midataId"
      :errors="errors.midataId"
    />
    <TextInput
      id="midataApiKey"
      :label="$t('dashboard.midataApiKey')"
      info="Is required to fetch camps from MiData"
      type="text"
      v-model="modifiableSettings.midataApiKey"
      :errors="errors.midataApiKey"
    />
    <SmallTitle>{{ $t("dashboard.footerSettings") }}</SmallTitle>
    <div>
      <Editor
        :label="$t('dashboard.contactInFooter')"
        v-model="modifiableSettings.contactInFooter"
      />
    </div>
    <SmallTitle>{{ $t("dashboard.alertBannerSettings") }}</SmallTitle>
    <CheckBox
      :label="$t('dashboard.showAlertBanner')"
      v-model="modifiableSettings.showAlert"
    />
    <div class="flex flex-row space-x-2">
      <div class="w-fit">
        <FormLabel>{{ $t("dashboard.textColor") }}</FormLabel>
        <ColorPicker v-model="modifiableSettings.alertTextColor" />
      </div>
      <div class="w-fit">
        <FormLabel>{{ $t("dashboard.bgColor") }}</FormLabel>
        <ColorPicker v-model="modifiableSettings.alertBgColor" />
      </div>
    </div>
    <TextInput
      id="alertText"
      class="w-full"
      :label="$t('dashboard.text')"
      v-model="modifiableSettings.alertText"
    />
    <TextInput
      id="alertUrl"
      :label="$t('dashboard.url')"
      v-model="modifiableSettings.alertUrl"
    />
  </div>
</template>
<script>
import TextInput from "../../components/admin/TextInput.vue";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import ColorPicker from "../../components/admin/ColorPicker.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import { faArrowsRotate } from "@fortawesome/free-solid-svg-icons";
import ActionButton from "../../components/admin/ActionButton.vue";
import SmallTitle from "../../components/admin/SmallTitle.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import InfoField from "../../components/admin/InfoField.vue";

export default {
  components: {
    TextInput,
    LogoDisplay,
    FormLabel,
    ColorPicker,
    Editor,
    ActionButton,
    SmallTitle,
    CheckBox,
    SelectComponent,
    InfoField,
  },
  data() {
    return {
      modifiableSettings: undefined,
      pages: [],
      icons: {
        faArrowsRotate,
      },
      errors: {},
    };
  },
  methods: {
    updateLogo(key, file) {
      this.modifiableSettings[`${key}Id`] = file?.id ? file?.id : null;
    },
    async getSettings() {
      try {
        const response = await this.callApi("get", "settings");
        this.modifiableSettings = response.data;
      } catch (error) {
        console.log(error);
      }
    },
    async updateSettings() {
      try {
        await this.callApi("put", "settings", this.modifiableSettings);
        this.notifyUser("Settings Updated");
      } catch (e) {
        if (e.response.status === 422) {
          this.errors = e.response.data.errors;
        }
      }
    },
    async getPages() {
      try {
        const response = await this.callApi(
          "get",
          "pages",
          {},
          {
            params: {
              limit: 100,
            },
          },
        );
        this.pages = response.data.data.map((p) => ({
          name: p.title,
          id: p.id,
        }));
      } catch (error) {
        console.log(error);
      }
    },
    handleNotFoundPage(value) {
      this.modifiableSettings.notFoundPageId = value;
    },
  },
  async created() {
    await this.getSettings();
    await this.getPages();
  },
};
</script>
