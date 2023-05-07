<template>
  <div v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.name }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Groups' }">
        <button class="rounded-l-lg bg-white p-1">
          <ChevronLeftIcon class="h-6 w-6 text-gray-500" />
        </button>
      </router-link>
      <div>
        <button
          @click="deletePage"
          class="bg-white p-1 border-r border-l border-gray-200"
        >
          <TrashIcon class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1" @click="updateGroup">
          <ArrowPathIcon class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card class="mt-4">
      <div class="flex flex-row space-x-2 h-full w-full">
        <LogoDisplay/>
      <div class="space-y-2 w-full">
        <TextInput label="Name" type="text" v-model="content.name" />
        <div class="flex flex-row justify-between space-x-2">
          <Select label="Stufe" @selectSection="(event)=>handleSection(event)" :value="content.section?content.section['id']:null" selection="Section" :options="sections"/>
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
import {
  ArrowPathIcon,
  ChevronLeftIcon,
  TrashIcon,
} from "@heroicons/vue/24/solid";
import LogoDisplay from "../../components/admin/LogoDisplay.vue";
export default {
  components: {
    Card,
    TextInput,
    ArrowPathIcon,
    ChevronLeftIcon,
    TrashIcon,
    Select,
    LogoDisplay
},
  data() {
    return {
      content: undefined,
      sections: undefined,
      showModal: false
    };
  },
  methods: {
    async getGroup() {
      try {
        const response = await this.callApi(
          "get",
          `/groups/${this.$route.params.id}`
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
    await this.getGroup();
    
  },
};
</script>

<style>
</style>