<template>
  <div v-if="content">
    <ItemHeaderTemplate :title="content.nickname" :content="content" entity="contacts" backLinkTo="Contacts" />
    <Card class="mt-4">
      <div class="flex flex-row space-x-5 h-full w-full">
        <LogoDisplay :logo="content.file" @selectImage="updateLogo"/>
      <div class="space-y-2 w-full">
        <TextInput label="Nickname" type="text" v-model="content.nickname" />
        <div class="flex flex-row justify-between space-x-2">
          <TextInput class="w-full" label="Vorname" type="text" v-model="content.firstname" />
        <TextInput class="w-full" label="Nachname" type="text" v-model="content.lastname" />
        </div>
        <TextInput label="E-Mail" type="email" v-model="content.email" />
        <TextInput label="Rolle" type="role" v-model="content.role" />
        
      </div>
    </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
export default {
  components: {
    Card,
    TextInput,
    LogoDisplay,
    ItemHeaderTemplate
},
  data() {
    return {
      content: undefined,
      sections: undefined,
      showModal: false,
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
      this.content.fileId = file.id;
      this.updateContact()

    },
    async getContact() {
      try {
        const response = await this.callApi(
          "get",
          `/contacts/${this.$route.params.id}`
        );
        this.content = response.data;
        this.loadedKey++;
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
      } catch (e) {
        console.log(e);
      }
    },
    async updateContact() {
      try {
        await this.callApi(
          "put",
          `/contacts/${this.$route.params.id}`,
          this.content
        );
        this.$store.dispatch(
          "notification/notify",
          "The Contact was successfully updated!"
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
    await this.getContact();
    
  },
};
</script>

<style>
</style>