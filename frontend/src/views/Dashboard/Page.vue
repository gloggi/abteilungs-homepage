<template>
  <div :key="loadedKey" v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.title }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
        <router-link :to="{name: 'Pages'}">
      <button class="rounded-l-lg bg-white p-1 ">
        <ChevronLeftIcon class="h-6 w-6 text-gray-500" />
      </button>
      </router-link>
      <div>
        <button class="rounded-l-lg bg-white p-1">
          <SwitchVerticalIcon class="h-6 w-6 text-gray-500" />
        </button>
        <button @click="deletePage" class="bg-white p-1 border-r border-l border-gray-200">
          <TrashIcon class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1 " @click="updateAll">
                 <RefreshIcon class="h-6 w-6 text-gray-500"/>
            </button>
      </div>
    </div>
    <Card>
      <TextInput label="Title" v-model="content.title" />
      <TextInput class="mt-2" label="Route" v-model="content.route" />
    </Card>
    <div v-for="pageItem in content.pageItems" :key="pageItem.sort">
      <AddPageItem
        :position="pageItem.sort"
        @addComponent="handleAddComponent"
      />
      <Fade>
        <Card>
          <TextInput label="Title" v-model="pageItem.title" />
          <Editor class="mt-2" v-model="pageItem.text" />
        </Card>
      </Fade>
    </div>
    <Modal />
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
import AddPageItem from "../../components/admin/AddPageItem.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import Fade from "../../transitions/Fade.vue";
import Modal from "../../components/admin/Modal.vue";
import { RefreshIcon, ChevronLeftIcon, TrashIcon, SwitchVerticalIcon } from '@heroicons/vue/solid'


export default {
  components: {
    TextInput,
    Card,
    AddPageItem,
    Editor,
    Fade,
    Modal,
    ChevronLeftIcon,
    RefreshIcon,
    TrashIcon,
    SwitchVerticalIcon
  },
  data() {
    return {
      content: undefined,
      loadedKey: 0,
    };
  },
  async created() {
    await this.getPage();
  },
  computed: {
    lastPageItemPosition() {
      if (this.content.pageItems.length > 0) {
        return (
          this.content.pageItems[this.content.pageItems.length - 1].sort + 1
        );
      }
      return 0;
    },
  },
  methods: {
    async handleAddComponent(event) {
      console.log(event);
      let pItems = this.content.pageItems;
      for (let i = 0; i < pItems.length; i++) {
        if (pItems[i].sort >= event.position) {
          pItems[i].sort = pItems[i].sort + 1;
        }
      }
      await this.createNewItem(this.content["@id"], event.type, event.position);
      await this.updateAll();
      await this.getPage();
    },
    async createNewItem(page, itemType, sort) {
      try {
        await this.callApi("post", `/${itemType}`, { sort, page });
      } catch (e) {
        console.log(e);
      }
    },
    async getPage() {
      try {
        const response = await this.callApi(
          "get",
          `/pages/${this.$route.params.id}`
        );
        this.content = response.data;
        console.log(this.content);
        this.loadedKey++;
      } catch (e) {
        console.log(e,);
      }
    },
    async updateAll() {
      this.content.pageItems.forEach(async (item) => {
        await this.callApi("put", `${item["@id"]}`, item);
      });
      const page = { ...this.content };
      delete page["pageItems"];
      try {
        const response = await this.callApi(
          "put",
          `/pages/${this.$route.params.id}`,
          page
        );
        this.content = response.data;
        console.log(this.content);
        this.loadedKey++;
        this.$store.dispatch("notification/notify", "Page updated");
      } catch (e) {
        console.log(e);
      }
    },
    async deletePage(){
        try {
        await this.callApi("delete", this.content["@id"]);
        this.$store.dispatch("notification/notify", "Page deleted");
        this.$router.push({name: "Pages"})
      } catch (e) {
        console.log(e);
      }
        

    },
    async deleteItem(iri) {
      try {
        await this.callApi("delete", iri);
        this.getPage();
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style></style>
