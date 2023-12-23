<template>
  <div>
    <ItemHeaderTemplate :title="content.name" :content="content" @errors="handleErrors" @clearErrors="errors = {}"
      entity="groups" backLinkTo="Groups" />
    <Card class="mt-4">
      <div class="flex flex-col md:flex-row items-center md:items-start space-x-0 md:space-x-5 space-y-5 md:space-y-0 h-full w-full">
        <LogoDisplay :key="loadedKey" :logo="content.file" @selectImage="updateLogo" />
        <div class="space-y-2 w-full">
          <TextInput label="Name" type="text" v-model="content.name" :errors="errors.name" />
          <Select label="Section" @selectSection="(event) => handleSection(event)"
            :value="content.section ? content.section['id'] : null" selection="Section" :options="sections"
            :errors="errors.sectionId" />
          <Select label="Gender" @selectGender="(event) => handleGender(event)" :value="content.gender" selection="Gender"
            :options="genders" :errors="errors.gender" />
          <div class="">
            <FormLabel>Group Color</FormLabel>
            <ColorPicker v-model="content.color" :errors="errors.color" />
          </div>
          <Select label="Parent Group" @selectParentGroup="(event) => handleParentGroup(event)"
            :value="content.parentId ? content.parentId : null" selection="ParentGroup" :options="groups" />
          <MultipleSelect label="Predecessor Groups" v-model="content.predecessors" :options="groups" />
          <MultipleSelect label="Successor Groups" v-model="content.successors" :options="groups" />
          <TextInput label="MiData Id" type="number" v-model="content.midataId" :errors="errors.midataId" />
          <div class="flex flex-col space-y-2">
          <FormLabel>Header Images</FormLabel>
        <BannerImageSelector info="The perfect aspect ratio is 32:9." :key="loadedKey" :item="{files: content.headerImages}" @changeImages="changeHeaderImages" />
      </div>  
        <div class="flex flex-col space-y-2">
            <FormLabel>Description</FormLabel>
            <Editor v-model="content.description" />
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Select from "../../components/admin/Select.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import ColorPicker from "../../components/admin/ColorPicker.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import BannerImageSelector from "../../components/admin/BannerImageSelector.vue";
export default {
  components: {
    Card,
    TextInput,
    Select,
    LogoDisplay,
    MultipleSelect,
    ItemHeaderTemplate,
    ColorPicker,
    FormLabel,
    Editor,
    BannerImageSelector
},
  data() {
    return {
      content: {},
      sections: undefined,
      showModal: false,
      loadedKey: 0,
      errors: {},
      groups: [],
      genders: [
        { id: 1, name: "Mixed" },
        { id: 2, name: "Male" },
        { id: 3, name: "Female" }
      ],
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus
      }
    };
  },
  methods: {
    updateLogo(file) {
      this.content.file_id = file.id;
      this.updateGroup()

    },
    async getGroup() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/groups/${this.$route.params.id}`
        );
        this.content = response.data;
        if (this.content.predecessors) {
          this.content.predecessors = this.content.predecessors.map(p => p.id)
        }
        if (this.content.successors) {
          this.content.successors = this.content.successors.map(p => p.id)
        }
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async getGroups() {
      try {
        const response = await this.callApi(
          "get",
          `/groups`
        );
        this.groups = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    async getSections() {
      try {
        const response = await this.callApi(
          "get",
          `/sections`
        );
        this.sections = response.data.data;
        console.log(this.sections)
      } catch (e) {
        console.log(e);
      }
    },
    async updateGroup() {
      try {
        await this.callApi(
          "put",
          `/groups/${this.$route.params.id}`,
          this.content
        );
      } catch (e) {
        console.log(e);
      }
    },
    handleSection(sectionId) {
      this.content.sectionId = sectionId
    },
    handleGender(genderId) {
      this.content.gender = genderId;
    },
    handleParentGroup(groupId) {
      this.content.parentId = groupId;
    },
    handleErrors(errors) {
      this.errors = errors
    },
    changeHeaderImages(event){
      this.content.headerImages= event.files;
    }
  },
  async created() {
    await this.getSections();
    await this.getGroups();
    await this.getGroup();

  },
};
</script>

<style></style>