<template>
  <div v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.name }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Contacts' }">
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
        <button class="rounded-r-lg bg-white p-1" @click="updateContact">
          <RefreshIcon class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card class="mt-4">
      <div class="flex flex-col md:flex-row  md:justify-between items-center">
        <div class="md:w-1/3 p-2">
        <div  class="relative w-full aspect-square">
          <ImageDropDown @remove="removeImage" />
        <img v-if="content.image" :src="content.image.contentUrl" class="w-full rounded-full"/>
        <div v-else class="w-full h-full rounded-full border border-gray-200 flex justify-center items-center text-gray-200">
          No image
        </div>
        </div>
          
        </div>
      <div class="space-y-2 w-full">
        <ColorPicker />
        <TextInput label="Name" type="text" v-model="content.name" />
        <TextInput label="Role" type="text" v-model="content.role" />
        <TextInput label="E-Mail" type="email" v-model="content.eMail" />
        <TextInput label="Sort" type="number" v-model="content.sort" />
        </div>
      </div>
      <MediaModal
      v-if="showModal"
      :preselected="[]"
      @selectImages="handleImages"
      @close="() => (showModal = false)"
    />
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
/* import Button  from "../../components/admin/Button.vue" */
import MediaModal from '../../components/admin/MediaModal.vue';
import ImageDropDown from '../../components/admin/ImageDropDown.vue'
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
    /* Button, */
    MediaModal,
    ImageDropDown
    
  },
  data() {
    return {
      content: undefined,
      showModal: false
    };
  },
  methods: {
    handleImages(images){
      if(images.length>0){
      this.content.image=images[0]
      }
    },
    removeImage(){
      this.content.image=null
    },
    async getContact() {
      try {
        const response = await this.callApi(
          "get",
          `/contacts/${this.$route.params.id}`
        );
        this.content = response.data;
        console.log(this.content);
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updateContact() {
      this.content.sort = parseFloat(this.content.sort)
      if(this.content.image&&typeof this.content.image != "string"){
      var tempImg = {...this.content.image}
      this.content.image = this.content.image["@id"]
      }
      try {
        await this.callApi(
          "put",
          `/contacts/${this.$route.params.id}`,
          this.content
        );
      } catch (e) {
        console.log(e);
      }
      this.content.image = tempImg
      this.loadedKey++;
    }
  },
  created() {
    this.getContact();
  },
};
</script>

<style>
</style>