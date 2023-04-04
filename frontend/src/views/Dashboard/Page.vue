<template>
  <div :key="loadedKey" v-if="pageInEdit">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ pageInEdit.title }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Pages' }">
        <button class="rounded-l-lg bg-white p-1">
          <ChevronLeftIcon class="h-6 w-6 text-gray-500" />
        </button>
      </router-link>
      <div>
        <button class="rounded-l-lg bg-white p-1">
          <SwitchVerticalIcon class="h-6 w-6 text-gray-500" />
        </button>
        <button
          @click="deletePage"
          class="bg-white p-1 border-r border-l border-gray-200"
        >
          <TrashIcon class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1" @click="updatePage">
          <RefreshIcon class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card>
      <TextInput label="Title" v-model="pageInEdit.title" />
      <TextInput class="mt-2" label="Route" v-model="pageInEdit.route" />
    </Card>
    <div v-for="pageItem in pageInEdit.page_items" :key="pageItem.sort">
      <AddPageItem
        :position="pageItem.sort"
        @addComponent="handleAddComponent"
      />
      <TextItem  v-if="pageItem['type'] == 'text'"  :item="pageItem" />
      <ImageItem  v-if="pageItem['type'] == 'image'" :item="pageItem" />
    </div>
    <AddPageItem
      :position="lastPageItemPosition"
      @addComponent="handleAddComponent"
    />
  </div>
</template>

<script>
//import Textarea from "../../components/admin/Textarea.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Card from "../../components/admin/Card.vue";
import AddPageItem from "../../components/admin/PageItems/AddPageItem.vue";
import {
  RefreshIcon,
  ChevronLeftIcon,
  TrashIcon,
  SwitchVerticalIcon,
} from "@heroicons/vue/solid";
import TextItem from '../../components/admin/PageItems/TextItem.vue';
import ImageItem from '../../components/admin/PageItems/ImageItem.vue';

export default {
  components: {
    TextInput,
    Card,
    AddPageItem,
    ChevronLeftIcon,
    RefreshIcon,
    TrashIcon,
    SwitchVerticalIcon,
    TextItem,
    ImageItem,
  },
  data() {
    return {
      content: undefined,
      loadedKey: 0,
      activeItemIri: undefined,
      preSelectedImages: undefined
    };
  },
  async created() {
    await this.getPage();
  },
  computed: {
    lastPageItemPosition() {
      /* if (this.content.page_items.length > 0) {
        return (
          this.content.page_items[this.content.page_items.length - 1].sort + 1
        );
      } */
      return 0;
    },
    pageInEdit(){
      return this.$store.state.pageInEdit.page
    }
  },
  methods: {
    async updateComponent(newItem){
      this.$store.commit("pageInEdit/updateItem",newItem)
    },
    async handleAddComponent(event) {
      this.content.page_items.push({type: event.type})
      this.loadedKey++;
      await this.updatePage()
      console.log(event.type=="text_item")
    },
    async getPage() {
      console.log("done")
      await this.$store.dispatch("pageInEdit/getPage",this.$route.params.id)
      this.loadedKey++;
    },
    async updatePage() {
      this.$store.dispatch("pageInEdit/updatePage")
      
    },
    async deletePage() {
      try {
        await this.callApi("delete", this.content["id"]);
        this.$store.dispatch("notification/notify", "Page deleted");
        this.$router.push({ name: "Pages" });
      } catch (e) {
        console.log(e);
      }
    },
    async deleteItem(id) {
      try {
        await this.callApi("delete", `pages/${id}`);
        this.getPage();
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style></style>
