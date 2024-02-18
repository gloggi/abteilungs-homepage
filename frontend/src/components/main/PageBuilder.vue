<template>
  <PageWrapper>
    <template v-for="pageItem in page.pageItems" :key="pageItem.id">
      <TextItem v-if="pageItem.type == 'textItem'" :item="pageItem" />
      <ImageItem v-if="pageItem.type == 'imageItem'" :item="pageItem" />
      <ContactItem v-if="pageItem.type == 'contactItem'" :item="pageItem" />
      <FormItem v-if="pageItem.type == 'formItem'" :item="pageItem" />
      <SectionsItem v-if="pageItem.type == 'sectionsItem'" :item="pageItem" />
      <GroupsItem v-if="pageItem.type == 'groupsItem'" :item="pageItem" />
      <FilesItem
        v-if="pageItem.type == 'filesItem'"
        :title="pageItem.title"
        :files="pageItem.files"
      />
      <CampsItem v-if="pageItem.type == 'campsItem'" :item="pageItem" />
      <LocationItem v-if="pageItem.type == 'locationItem'" :item="pageItem" />
    </template>
  </PageWrapper>
</template>
<script>
import CampsItem from "./CampsItem.vue";
import ContactItem from "./ContactItem.vue";
import FilesItem from "./FilesItem.vue";
import FormItem from "./FormItem.vue";
import GroupsItem from "./GroupsItem.vue";
import ImageItem from "./ImageItem.vue";
import PageWrapper from "./PageWrapper.vue";
import SectionsItem from "./SectionsItem.vue";
import TextItem from "./TextItem.vue";
import LocationItem from "./LocationItem.vue";

export default {
  props: ["page"],
  data() {
    return {};
  },
  methods: {},
  async created() {},
  components: {
    TextItem,
    ImageItem,
    ContactItem,
    FormItem,
    SectionsItem,
    GroupsItem,
    PageWrapper,
    FilesItem,
    CampsItem,
    LocationItem,
  },
};
</script>
