<template>
  <div v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.name }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Sections' }">
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
        <button class="rounded-r-lg bg-white p-1" @click="updateSection">
          <RefreshIcon class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card class="mt-4">
      <div class="space-y-2">
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
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import {
  RefreshIcon,
  ChevronLeftIcon,
  TrashIcon,
} from "@heroicons/vue/solid";
export default {
  components: {
    Card,
    TextInput,
    RefreshIcon,
    ChevronLeftIcon,
    TrashIcon,
    
  },
  data() {
    return {
      content: undefined,
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
    }
  },
  created() {
    this.getSection();
  },
};
</script>

<style>
</style>