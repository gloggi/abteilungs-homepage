<template>
  <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
    <h2 class="font-extrabold text-4xl">{{ $t("dashboard.settings") }}</h2>
  </div>
  <div class="flex justify-end mb-2">
    <div>
      <ActionButton @click="updateSettings">
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
      :label="$t('dashboard.siteTitle')"
      v-model="modifiableSettings.siteTitle"
      :errors="errors.siteTitle"
    />
    <TextInput
      :label="$t('dashboard.divisionName')"
      v-model="modifiableSettings.divisionName"
      :errors="errors.divisionName"
    />
    <div class="flex flex-col md:flex-row">
      <div class="w-1/2">
        <FormLabel>{{ $t("dashboard.divisionLogo") }}</FormLabel>
        <LogoDisplay
          :logo="modifiableSettings.divisionLogo"
          @selectImage="(e) => updateLogo('divisionLogo', e)"
        />
      </div>
      <div class="w-1/2">
        <FormLabel>{{ $t("dashboard.websiteIcon") }}</FormLabel>
        <LogoDisplay
          :logo="modifiableSettings.websiteIcon"
          @selectImage="(e) => updateLogo('websiteIcon', e)"
        />
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
      :label="$t('dashboard.midataId')"
      type="number"
      v-model="modifiableSettings.midataId"
      :errors="errors.midataId"
    />
    <TextInput
      :label="$t('dashboard.midataApiKey')"
      info="Is required to fetch camps from MiData"
      type="text"
      v-model="modifiableSettings.midataApiKey"
      :errors="errors.midataApiKey"
    />
    <SmallTitle>{{ $t("dashboard.footerSettings") }}</SmallTitle>
    <div>
      <FormLabel>{{ $t("dashboard.contactInFooter") }}</FormLabel>
      <Editor v-model="modifiableSettings.contactInFooter" />
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
      class="w-full"
      :label="$t('dashboard.text')"
      v-model="modifiableSettings.alertText"
    />
    <TextInput
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
      this.modifiableSettings[`${key}Id`] = file.id;
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
