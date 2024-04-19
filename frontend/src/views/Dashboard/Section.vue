<template>
  <div>
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="sections"
      backLinkTo="Sections"
    />
    <Card class="mt-4 space-y-5">
      <div
        class="flex flex-col items-center md:items-start md:flex-row space-x-0 md:space-x-5 space-y-5 md:space-y-0 h-full w-full"
      >
        <LogoDisplay
          :key="loadedKey"
          :logo="content.file"
          :objectContain="true"
          @selectImage="updateLogo"
          :size="65"
          :backgroundColor="content.color"
        />
        <div class="space-y-2 w-full">
          <TextInput
            id="name"
            :label="$t('dashboard.name')"
            type="text"
            v-model="content.name"
            :errors="errors.name"
          />
          <div class="flex flex-row justify-between space-x-2">
            <TextInput
              id="fromAge"
              class="w-full"
              :label="$t('dashboard.fromAge')"
              type="number"
              v-model="content.fromAge"
              :errors="errors.fromAge"
            />
            <TextInput
              id="toAge"
              class="w-full"
              :label="$t('dashboard.toAge')"
              type="number"
              v-model="content.toAge"
              :errors="errors.toAge"
            />
          </div>
          <div>
            <TextInput
              :label="$t('dashboard.sort')"
              type="number"
              v-model="content.sort"
              :errors="errors.sort"
            />
            <InfoField :info="$t('dashboard.sectionSortInfo')" />
          </div>
          <div class="">
            <FormLabel>{{ $t("dashboard.sectionColor") }}</FormLabel>
            <ColorPicker v-model="content.color" :errors="errors.color" />
          </div>
          <div class="flex-space-y-2">
            <FormLabel>{{ $t("dashboard.sectionHeaderImages") }}</FormLabel>
            <BannerImageSelector
              :key="loadedKey"
              :item="content"
              @changeImages="changeHeaderImages"
            />
          </div>
          <div class="flex-space-y-2">
            <Editor
              :label="$t('dashboard.description')"
              id="description"
              v-model="content.description"
            />
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
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import BannerImageSelector from "../../components/admin/BannerImageSelector.vue";
import ColorPicker from "../../components/admin/ColorPicker.vue";
import InfoField from "../../components/admin/InfoField.vue";
export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    LogoDisplay,
    Editor,
    FormLabel,
    BannerImageSelector,
    ColorPicker,
    InfoField,
  },
  data() {
    return {
      content: {},
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
    async getSection() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/sections/${this.$route.params.id}`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updateSection() {
      try {
        await this.callApi(
          "put",
          `/sections/${this.$route.params.id}`,
          this.content,
        );
      } catch (e) {
        console.log(e);
      }
    },
    updateLogo(file) {
      this.content.fileId = file?.id || null;
    },
    changeHeaderImages(event) {
      this.content.files = event.files;
    },
    handleErrors(errors) {
      this.errors = errors;
    },
  },
  async created() {
    await this.getSection();
  },
};
</script>

<style></style>
