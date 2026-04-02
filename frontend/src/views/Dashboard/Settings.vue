<template>
  <div>
    <PageHeader :title="$t('dashboard.settings')">
      <template #actions>
        <div v-if="modifiableSettings">
          <ActionButton
            @click="updateSettings"
            :toolTipText="$t('dashboard.saveChanges')"
          >
            <font-awesome-icon :icon="icons.faArrowsRotate" class="h-4 w-4" />
          </ActionButton>
        </div>
      </template>
    </PageHeader>

    <div v-if="modifiableSettings" class="grid gap-6">
      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.generalSettings") }}</SmallTitle>
          <div class="grid gap-4 md:grid-cols-2">
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
          </div>
          <SelectComponent
            id="navbarPosition"
            selection="NavbarPosition"
            :label="$t('dashboard.navbarPosition')"
            @selectNavbarPosition="handleNavbarPosition"
            :returnInt="false"
            :value="modifiableSettings.navbarPosition"
            :options="navbarPositionOptions"
            :errors="errors.navbarPosition"
          />

          <div class="grid gap-8 pt-4 md:grid-cols-3">
            <div class="flex flex-col items-center gap-3">
              <FormLabel>{{ $t("dashboard.divisionLogo") }}</FormLabel>
              <LogoDisplay
                :allowedExtensions="[
                  'svg',
                  'png',
                  'jpg',
                  'jpeg',
                  'gif',
                  'webp',
                ]"
                :logo="modifiableSettings.divisionLogo"
                @selectImage="(e) => updateLogo('divisionLogo', e)"
              />
            </div>
            <div class="flex flex-col items-center gap-3">
              <FormLabel>{{ $t("dashboard.websiteIcon") }}</FormLabel>
              <LogoDisplay
                :logo="modifiableSettings.websiteIcon"
                @selectImage="(e) => updateLogo('websiteIcon', e)"
                :allowedExtensions="['png', 'jpg', 'jpeg', 'gif', 'webp']"
              />
            </div>
            <div class="flex flex-col items-center gap-3">
              <FormLabel>{{ $t("dashboard.socialIcon") }}</FormLabel>
              <LogoDisplay
                :logo="modifiableSettings.socialIcon"
                @selectImage="(e) => updateLogo('socialIcon', e)"
                :allowedExtensions="['png', 'jpg', 'jpeg']"
              />
              <InfoField :info="$t('dashboard.socialIconInfo')" />
            </div>
          </div>
        </div>
      </Card>

      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.designSettings") }}</SmallTitle>
          <div class="grid gap-6 md:grid-cols-3">
            <div>
              <FormLabel>{{ $t("dashboard.primaryColor") }}</FormLabel>
              <ColorPicker
                id="primaryColor"
                v-model="modifiableSettings.primaryColor"
              />
            </div>
            <div>
              <FormLabel>{{ $t("dashboard.secondaryColor") }}</FormLabel>
              <ColorPicker
                id="secondaryColor"
                v-model="modifiableSettings.secondaryColor"
              />
            </div>
            <div>
              <FormLabel>{{ $t("dashboard.navbarFontColor") }}</FormLabel>
              <ColorPicker
                id="navbarFontColor"
                v-model="modifiableSettings.navbarFontColor"
              />
            </div>
            <div>
              <TextInput
                id="fontSize"
                :label="$t('dashboard.fontSize')"
                v-model="modifiableSettings.fontSize"
                type="number"
                :errors="errors.fontSize"
              />
            </div>
            <div>
              <SelectComponent
                id="fontWeightHeading1"
                selection="FontWeightHeading1"
                :label="$t('dashboard.fontWeightH1')"
                @selectFontWeightHeading1="handleFontWeight('fontWeightHeading1', $event)"
                :value="modifiableSettings.fontWeightHeading1"
                :options="fontWeightOptions"
                :errors="errors.fontWeightHeading1"
              />
            </div>
            <div>
              <SelectComponent
                id="fontWeightHeading2"
                selection="FontWeightHeading2"
                :label="$t('dashboard.fontWeightH2')"
                @selectFontWeightHeading2="handleFontWeight('fontWeightHeading2', $event)"
                :value="modifiableSettings.fontWeightHeading2"
                :options="fontWeightOptions"
                :errors="errors.fontWeightHeading2"
              />
            </div>
            <div>
              <SelectComponent
                id="fontWeightHeading3"
                selection="FontWeightHeading3"
                :label="$t('dashboard.fontWeightH3')"
                @selectFontWeightHeading3="handleFontWeight('fontWeightHeading3', $event)"
                :value="modifiableSettings.fontWeightHeading3"
                :options="fontWeightOptions"
                :errors="errors.fontWeightHeading3"
              />
            </div>
            <div>
              <FormLabel>{{ $t("dashboard.sideBgColor") }}</FormLabel>
              <ColorPicker
                id="sideBgColor"
                v-model="modifiableSettings.sideBgColor"
              />
            </div>
          </div>
        </div>
      </Card>

      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.pageSettings") }}</SmallTitle>
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
        </div>
      </Card>

      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.midataSettings") }}</SmallTitle>
          <div class="grid gap-4 md:grid-cols-2">
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
              :info="$t('dashboard.midataApiKeyInfo')"
              type="text"
              v-model="modifiableSettings.midataApiKey"
              :errors="errors.midataApiKey"
            />
          </div>
        </div>
      </Card>

      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.footerSettings") }}</SmallTitle>
          <Editor
            :label="$t('dashboard.contactInFooter')"
            v-model="modifiableSettings.contactInFooter"
          />
        </div>
      </Card>

      <Card>
        <div class="space-y-6">
          <SmallTitle>{{ $t("dashboard.alertBannerSettings") }}</SmallTitle>
          <CheckBox
            :label="$t('dashboard.showAlertBanner')"
            v-model="modifiableSettings.showAlert"
          />
          <div v-if="modifiableSettings.showAlert" class="space-y-4">
            <div class="flex gap-6">
              <div>
                <FormLabel>{{ $t("dashboard.textColor") }}</FormLabel>
                <ColorPicker
                  id="alertTextColor"
                  v-model="modifiableSettings.alertTextColor"
                />
              </div>
              <div>
                <FormLabel>{{ $t("dashboard.bgColor") }}</FormLabel>
                <ColorPicker
                  id="alertBgColor"
                  v-model="modifiableSettings.alertBgColor"
                />
              </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
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
          </div>
        </div>
      </Card>
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
import ActionButton from "../../components/admin/ActionButton.vue";
import SmallTitle from "../../components/admin/SmallTitle.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import InfoField from "../../components/admin/InfoField.vue";
import PageHeader from "../../components/admin/PageHeader.vue";
import Card from "../../components/admin/Card.vue";

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
    PageHeader,
    Card,
  },
  data() {
    return {
      modifiableSettings: undefined,
      pages: [],
      icons: {
        faArrowsRotate,
      },
      errors: {},
      navbarPositionOptions: [
        { name: this.$t("dashboard.navbarTop"), id: "top", value: "top" },
        {
          name: this.$t("dashboard.navbarBetweenHeaderAndContent"),
          id: "between_header_and_content",
          value: "between_header_and_content",
        },
      ],
      fontWeightOptions: [
        { name: "100 - Thin", id: 100 },
        { name: "200 - Extra Light", id: 200 },
        { name: "300 - Light", id: 300 },
        { name: "400 - Regular", id: 400 },
        { name: "500 - Medium", id: 500 },
        { name: "600 - Semi Bold", id: 600 },
        { name: "700 - Bold", id: 700 },
        { name: "800 - Extra Bold", id: 800 },
        { name: "900 - Black", id: 900 },
      ],
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
    handleNavbarPosition(value) {
      console.log(value);
      this.modifiableSettings.navbarPosition = value;
    },
    handleFontWeight(key, value) {
      this.modifiableSettings[key] = value;
    },
  },
  async created() {
    await this.getSettings();
    await this.getPages();
  },
};
</script>
