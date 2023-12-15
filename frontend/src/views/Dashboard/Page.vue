<template>
  <div v-if="content"  :key="loadedKey">
    <ItemHeaderTemplate :title="content.title" :content="content" entity="pages" backLinkTo="Pages" />
    <Card>
      <TextInput label="Title" v-model="content.title" />
      <TextInput class="mt-2" label="Route" v-model="content.route" />
      <div class="pt-2">
        <FormLabel>Header Images</FormLabel>
        <BannerImageSelector :item="content" @changeImages="changeHeaderImages" />
      </div>
      
    </Card>
    <AddPageItem @changeOrder="changeOrder" @select="addItem" :dragging="isDragging" :sortKey="-1" />
    <div v-for="(pageItem, i) in content.pageItems" :key="i">
      
      <TextItem v-if="pageItem.type == 'textItem'" boxTitle="Text Item" @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i"   :item="pageItem"  v-model:title="pageItem.title"  v-model:body="pageItem.body"  />
      <ImageItem v-if="pageItem.type == 'imageItem'" boxTitle="Image Item"  @changeImages="changeImageItem" :item="pageItem" @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i" />
      <FormItem v-if="pageItem.type == 'formItem'" boxTitle="Form Item"  @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i"  @changeForm="changeFormItem" :item="pageItem" />
      <ContactItem v-if="pageItem.type == 'contactItem'" boxTitle="Contact Item"  @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i" :item="pageItem"  />
      <GroupsItem v-if="pageItem.type == 'groupsItem'" boxTitle="Groups Item"  @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i" :item="pageItem"  />
      <SectionsItem v-if="pageItem.type == 'sectionsItem'" boxTitle="Sections Item"  @delete="deleteItem" @startedDragging="isDragging=true" @endedDragging="isDragging=false" :key="i" :item="pageItem"  />
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

import FormItem from "../../components/admin/PageItems/FormItem.vue";
import ContactItem from "../../components/admin/PageItems/ContactItem.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import BannerImageSelector from "../../components/admin/BannerImageSelector.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import GroupsItem from "../../components/admin/PageItems/GroupsItem.vue";
import SectionsItem from "../../components/admin/PageItems/SectionsItem.vue";

export default {
  components: {
    TextInput,
    Card,
    AddPageItem,
    TextItem,
    ImageItem,
    FormItem,
    ContactItem,
    ItemHeaderTemplate,
    BannerImageSelector,
    FormLabel,
    GroupsItem,
    SectionsItem
},
  data() {
    return {
      content: {
        files: [],
        pageItems: []
      },
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
        if(this.$route.params.id==="new"){
          return;
        }
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
          `/pages/${this.content.id}`,
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
      this.content.pageItems= this.content.pageItems.filter(p=>`${p.id}${p.type}`!==idAndType)
      this.updatePage()
    },
    changeImageItem(event){
      const pageItemId = event.id;
      const files = event.files;
      const itemIndex = this.content.pageItems.findIndex(p=>p.id==pageItemId&&p.type=="imageItem");
      this.content.pageItems[itemIndex].files = files;
    },
    changeFormItem(event){
      const pageItemId = event.id;
      const formId = event.formId;
      const itemIndex = this.content.pageItems.findIndex(p=>p.id==pageItemId&&p.type=="formItem");

      this.content.pageItems[itemIndex].formId = formId;
    },
    changeHeaderImages(event){
      this.content.files= event.files;
    },
    slugyfy(text){
      return kebabCase(text)
    },
    
    
  },
  watch: {
    'content.title'(newVal) {
      if(this.$route.params.id=="new"){
        this.content.route = this.slugyfy(newVal)
      }
      
    }
  },
};
</script>

<style></style>
