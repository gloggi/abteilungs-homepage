<template>
  <div v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.nickname }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Contacts' }">
        <button class="rounded-l-lg bg-white p-1">
          <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6 text-gray-500" />
        </button>
      </router-link>
      <div>
        <button
          @click="deletePage"
          class="bg-white p-1 border-r border-l border-gray-200"
        >
        <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1" @click="updateContact">
          <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card class="mt-4">
      <div class="flex flex-row space-x-2 h-full w-full">
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
export default {
  components: {
    Card,
    TextInput,
    LogoDisplay
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
    updateLogo(id){
      this.content.file_id = id;
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
        console.log(this.sections)
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