<template>
  <div>
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="groups"
      backLinkTo="Groups"
    />
    <Card class="mt-4">
      <div
        class="flex flex-col md:flex-row items-center md:items-start space-x-0 md:space-x-5 space-y-5 md:space-y-0 h-full w-full"
      >
        <LogoDisplay
          :key="loadedKey"
          :logo="content.file"
          @selectImage="updateLogo"
        />
        <div class="space-y-2 w-full">
          <TextInput
            :label="$t('dashboard.name')"
            type="text"
            v-model="content.name"
            :errors="errors.name"
          />
          <BreakpointSpaceManager>
            <SelectComponent
              :label="$t('dashboard.section')"
              @selectSection="(event) => handleSection(event)"
              :value="content.section ? content.section['id'] : null"
              selection="Section"
              :options="sections"
              :errors="errors.sectionId"
            />
            <SelectComponent
              :label="$t('dashboard.gender')"
              @selectGender="(event) => handleGender(event)"
              :value="content.gender"
              selection="Gender"
              :options="genders"
              :errors="errors.gender"
            />
          </BreakpointSpaceManager>
          <TextInput
            :label="$t('dashboard.region')"
            type="text"
            v-model="content.region"
            :errors="errors.region"
          />
          <div class="">
            <FormLabel>{{ $t("dashboard.groupColor") }}</FormLabel>
            <ColorPicker v-model="content.color" :errors="errors.color" />
          </div>
          <SelectComponent
            :label="$t('dashboard.parentGroup')"
            @selectParentGroup="(event) => handleParentGroup(event)"
            :value="content.parentId ? content.parentId : null"
            selection="ParentGroup"
            :options="groups"
          />
          <BreakpointSpaceManager>
            <MultipleSelect
              :label="$t('dashboard.predecessorGroups')"
              v-model="content.predecessors"
              :options="groups"
            />
            <MultipleSelect
              :label="$t('dashboard.successorGroups')"
              v-model="content.successors"
              :options="groups"
            />
          </BreakpointSpaceManager>
          <SelectComponent
            :label="$t('dashboard.groupLeader')"
            :value="content.groupLeaderId"
            selection="GroupLeader"
            @selectGroupLeader="handleSelectGroupLeader"
            :options="formatedUsers"
            :errors="errors.groupType"
          />
          <TextInput
            :label="$t('dashboard.midataId')"
            type="number"
            v-model="content.midataId"
            :errors="errors.midataId"
          />
          <TextInput
            :label="$t('dashboard.externalLink')"
            type="url"
            placeholder="https://"
            v-model="content.externalLink"
            :errors="errors.externalLink"
          />
          <InfoField :info="$t('dashboard.externalLinkInfo')" />
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import ColorPicker from "../../components/admin/ColorPicker.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import BannerImageSelector from "../../components/admin/BannerImageSelector.vue";
import FilesSelector from "../../components/admin/FilesSelector.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import BreakpointSpaceManager from "../../components/admin/BreakpointSpaceManager.vue";
import InfoField from "../../components/admin/InfoField.vue";
export default {
  components: {
    Card,
    TextInput,
    SelectComponent,
    LogoDisplay,
    MultipleSelect,
    ItemHeaderTemplate,
    ColorPicker,
    FormLabel,
    Editor,
    BannerImageSelector,
    FilesSelector,
    CheckBox,
    BreakpointSpaceManager,
    InfoField,
  },
  data() {
    return {
      content: {},
      sections: undefined,
      showModal: false,
      loadedKey: 0,
      errors: {},
      groups: [],
      users: [],
      genders: [
        { id: 1, name: "Mixed" },
        { id: 2, name: "Male" },
        { id: 3, name: "Female" },
      ],
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
      this.content.file_id = file ? file.id : null;
      this.updateGroup();
    },
    async getGroup() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/groups/${this.$route.params.id}`,
        );
        this.content = response.data;
        if (this.content.predecessors) {
          this.content.predecessors = this.content.predecessors.map(
            (p) => p.id,
          );
        }
        if (this.content.successors) {
          this.content.successors = this.content.successors.map((p) => p.id);
        }
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async getGroups() {
      try {
        const response = await this.callApi("get", `/groups`);
        this.groups = response.data.data;
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
    async updateGroup() {
      try {
        await this.callApi(
          "put",
          `/groups/${this.$route.params.id}`,
          this.content,
        );
      } catch (e) {
        console.log(e);
      }
    },
    async getUsers() {
      try {
        const response = await this.callApi("get", `/users`);
        this.users = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    handleSection(sectionId) {
      this.content.sectionId = sectionId;
    },
    handleGender(genderId) {
      this.content.gender = genderId;
    },
    handleParentGroup(groupId) {
      this.content.parentId = groupId;
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    handleSelectGroupLeader(userId) {
      this.content.groupLeaderId = userId;
    },
    changeHeaderImages(event) {
      this.content.headerImages = event.files;
    },
    changeFiles(event) {
      this.content.files = event.files;
    },
  },
  computed: {
    formatedUsers() {
      return this.users.map((user) => {
        return {
          id: user.id,
          name: `${user.nickname} (${user.firstname} ${user.lastname})`,
        };
      });
    },
  },
  async created() {
    await this.getSections();
    await this.getGroups();
    await this.getGroup();
    await this.getUsers();
  },
};
</script>

<style></style>
