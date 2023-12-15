<template>
  <div v-if="content">
    <ItemHeaderTemplate :title="content.name" :content="content" entity="sections" backLinkTo="Sections" />
    <Card class="mt-4 space-y-5">
      <div class="flex flex-row space-x-5 h-full w-full">
        <LogoDisplay :logo="content.file" :objectContain="true" @selectImage="updateLogo"/>
      <div class="space-y-2 w-full">
        <TextInput label="Name" type="text" v-model="content.name" />
        <div class="flex flex-row justify-between space-x-2">
          <TextInput
            class="w-full"
            label="From Age"
            type="number"
            v-model="content.fromAge"
          />
          <TextInput
            class="w-full"
            label="To Age"
            type="number"
            v-model="content.toAge"
          />
        </div>
      </div>
      </div>
      <div class="flex-space-y-2">
      <FormLabel>Description</FormLabel>
        <Editor v-model="content.description" />
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    LogoDisplay,
    Editor,
    FormLabel
},
  data() {
    return {
      content: undefined,
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus
      }
    };
  },
  methods: {
    async getSection() {
      try {
        const response = await this.callApi(
          "get",
          `/sections/${this.$route.params.id}`
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
         this.content
        );
      } catch (e) {
        console.log(e);
      }
    },
    updateLogo(file){
      this.content.file_id = file.id;
      this.updateGroup()

    }
  },
  created() {
    this.getSection();
  },
};
</script>

<style>
</style>