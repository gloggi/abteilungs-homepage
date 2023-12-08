<template>
  <div v-if="content"  :key="loadedKey">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.title }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Pages' }">
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
        <button class="rounded-r-lg bg-white p-1" @click="updatePage">
          <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card>
      <TextInput label="Title" v-model="content.title" />
      <TextInput class="mt-2" label="Route" v-model="content.route" />
    </Card>
    <AddPageItem @changeOrder="changeOrder" @select="addItem" :dragging="isDragging" :sortKey="-1" />
    <div v-for="(pageItem, i) in content.pageItems" :key="i">
      <DragItemBox  v-if="pageItem.type == 'textItem'" :item="pageItem" title="Text Item" @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i">
      <TextItem  :item="pageItem"  v-model:title="pageItem.title"  v-model:body="pageItem.body"  />
    </DragItemBox>
    <DragItemBox  v-if="pageItem.type == 'imageItem'" title="Image Item" :item="pageItem" @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i">
      <ImageItem  @changeImages="changeImageItem" :item="pageItem" />
      </DragItemBox>
      <DragItemBox  v-if="pageItem.type == 'formItem'" title="Form Item" :item="pageItem" @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i">
      <FormItem  @changeForm="changeFormItem" :item="pageItem" />
      </DragItemBox>
      <AddPageItem @changeOrder="changeOrder" @select="addItem" :dragging="isDragging" :sortKey="pageItem.sort" />
    </div>
    
  </div>
</template>

<script>
//import Textarea from "../../components/admin/Textarea.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Card from "../../components/admin/Card.vue";
import AddPageItem from "../../components/admin/AddPageItem.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import TextItem from '../../components/admin/PageItems/TextItem.vue';
import ImageItem from '../../components/admin/PageItems/ImageItem.vue';
import {kebabCase} from 'lodash';
import DragItemBox from "../../components/admin/DragItemBox.vue";
import FormItem from "../../components/admin/PageItems/FormItem.vue";

export default {
  components: {
    TextInput,
    Card,
    AddPageItem,
    TextItem,
    ImageItem,
    DragItemBox,
    FormItem
},
  data() {
    return {
      content: undefined,
      loadedKey: 0,
      activeItemIri: undefined,
      preSelectedImages: undefined,
      isDragging: false,
      icons: {
        faTrash,
        faPlus,
        faArrowsRotate,
        faChevronLeft
      }
    };
  },
  async created() {
    await this.getPage();
  },
  computed: {

  },
  methods: {
    async getPage() {
      try {
        const response = await this.callApi(
          "get",
          `/pages/${this.$route.params.id}`
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updatePage() {
      try {
        await this.callApi(
          "put",
          `/pages/${this.$route.params.id}`,
          this.content
        );
        this.getPage();
        this.$store.dispatch(
          "notification/notify",
          "The page has been successfully updated"
        );
      } catch (e) {
        console.log(e);
      }
    },
    addItem(field){
      this.content.pageItems.push(field)
      this.updatePage();
    },
    changeOrder(newItem){
      const itemIndex = this.content.pageItems.findIndex(p=>p.id==newItem.id);
      this.content.pageItems[itemIndex] = newItem
      this.updatePage()

    },
    deleteItem(idAndType){
      console.log(this.content.pageItems.length)
      this.content.pageItems= this.content.pageItems.filter(p=>`${p.id}${p.type}`!==idAndType)
      console.log(this.content.pageItems.length)
      this.updatePage()
    },
    changeImageItem(event){
      const pageItemId = event.id;
      const files = event.files;
      const itemIndex = this.content.pageItems.findIndex(p=>p.id==pageItemId&&p.type=="imageItem");
      this.content.pageItems[itemIndex].files = files;
    },
    changeFormItem(event){
      console.log(event)
      const pageItemId = event.id;
      const formId = event.formId;
      console.log(pageItemId, formId)
      const itemIndex = this.content.pageItems.findIndex(p=>p.id==pageItemId&&p.type=="formItem");

      this.content.pageItems[itemIndex].formId = formId;
    },
    slugyfy(text){
      return kebabCase(text)
    },
    
    
  },
  watch: {
    'content.title'(newVal) {
      this.content.route = this.slugyfy(newVal)
    }
  },
};
</script>

<style></style>
