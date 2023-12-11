<template>
  <div v-if="content">
    <ItemHeaderTemplate :title="content.name" :content="content" entity="groups" backLinkTo="Groups" />
    <Card class="mt-4">
      <div class="flex flex-row space-x-2 h-full w-full">
        <LogoDisplay :logo="content.file" @selectImage="updateLogo"/>
      <div class="space-y-2 w-full">
        <TextInput label="Name" type="text" v-model="content.name" />
        <div class="flex flex-row justify-between space-x-2">
          <Select label="Stufe" @selectSection="(event)=>handleSection(event)" :value="content.section?content.section['id']:null" selection="Section" :options="sections"/>
        </div>
        <MultipleSelect label="Vorgängergruppe" v-model="content.predecessors" :options="groups" />
        <MultipleSelect label="Nachfolgergruppen" v-model="content.successors" :options="groups" />
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
export default {
  components: {
    Card,
    TextInput,
    Select,
    LogoDisplay,
    MultipleSelect,
    ItemHeaderTemplate
},
  data() {
    return {
      content: undefined,
      sections: undefined,
      showModal: false,
      groups: [],
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus
      }
    };
  },
  methods: {
    updateLogo(file){
      this.content.file_id = file.id;
      this.updateGroup()

    },
    async getGroup() {
      try {
        const response = await this.callApi(
          "get",
          `/groups/${this.$route.params.id}`
        );
        this.content = response.data;
        if(this.content.predecessors){
          this.content.predecessors = this.content.predecessors.map(p=>p.id)
        }
        if(this.content.successors){
          this.content.successors = this.content.successors.map(p=>p.id)
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
    handleSection(sectionId){
      this.content.sectionId = sectionId
    }
  },
  async created() {
    await this.getSections();
    await this.getGroups();
    await this.getGroup();
    
  },
};
</script>

<style>
</style>