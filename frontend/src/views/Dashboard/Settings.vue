<template>
  <div class="bg-gray-50 rounded-lg p-5 flex items-center mb-2">
    <h2 class="font-extrabold text-4xl">{{ $t("dashboard.settings") }}</h2>
  </div>
  <div class="flex justify-end mb-2">
    <div>
      <button class="rounded-r-lg bg-white p-1" @click="updateSettings">
        <font-awesome-icon
          :icon="icons.faArrowsRotate"
          class="h-6 w-6 text-gray-400"
        />
      </button>
    </div>
  </div>
  <div
    v-if="this.settings"
    class="bg-gray-50 rounded-lg p-3 flex flex-col space-y-2"
  >
    <TextInput
      :label="$t('dashboard.siteTitle')"
      v-model="settings.siteTitle"
    />
    <TextInput
      :label="$t('dashboard.divisionName')"
      v-model="settings.divisionName"
    />
    <div class="flex">
      <div class="w-1/2">
        <FormLabel>{{ $t("dashboard.divisionLogo") }}</FormLabel>
        <LogoDisplay
          :logo="settings.divisionLogo"
          @selectImage="(e) => updateLogo('divisionLogo', e)"
        />
      </div>
      <div class="w-1/2">
        <FormLabel>{{ $t("dashboard.websiteIcon") }}</FormLabel>
        <LogoDisplay
          :logo="settings.websiteIcon"
          @selectImage="(e) => updateLogo('websiteIcon', e)"
        />
      </div>
    </div>
    <div class="flex space-x-8">
      <div class="">
        <FormLabel>{{ $t("dashboard.primaryColor") }}</FormLabel>
        <ColorPicker v-model="settings.primaryColor" />
      </div>
      <div class="">
        <FormLabel>{{ $t("dashboard.secondaryColor") }}</FormLabel>
        <ColorPicker v-model="settings.secondaryColor" />
      </div>
    </div>
    <TextInput
      :label="$t('dashboard.midataId')"
      type="number"
      v-model="settings.midataId"
    />
    <TextInput
      :label="$t('dashboard.midataParentId')"
      type="number"
      v-model="settings.midataParentId"
    />
    <TextInput
      :label="$t('dashboard.midataApiKey')"
      info="Is required to fetch camps from MiData"
      type="text"
      v-model="settings.midataApiKey"
    />
    <div>
      <FormLabel>{{ $t("dashboard.contactInFooter") }}</FormLabel>
      <Editor v-model="settings.contactInFooter" />
    </div>
  </div>
</template>
<script>
import TextInput from "../../components/admin/TextInput.vue";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import ColorPicker from "../../components/admin/ColorPicker.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import { faArrowsRotate } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { TextInput, LogoDisplay, FormLabel, ColorPicker, Editor },
  data() {
    return {
      settings: undefined,
      icons: {
        faArrowsRotate,
      },
    };
  },
  methods: {
    updateLogo(key, file) {
      this.settings[`${key}Id`] = file.id;
    },
    async getSettings() {
      try {
        const response = await this.callApi("get", "settings");
        this.settings = response.data;
      } catch (error) {
        console.log(error);
      }
    },
    async updateSettings() {
      try {
        await this.callApi("put", "settings", this.settings);
        this.notifyUser("Settings Updated");
      } catch (error) {
        console.log(error);
      }
    },
  },
  async created() {
    await this.getSettings();
  },
};
</script>
