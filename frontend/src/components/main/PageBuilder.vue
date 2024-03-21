<template>
  <PageWrapper>
    <template v-for="(pageItem, i) in page.pageItems" :key="pageItem.id">
      <TextItem v-if="pageItem.type == 'textItem'" :item="pageItem" />
      <ImageItem
        v-if="pageItem.type == 'imageItem'"
        :style="getMargins(i)"
        :item="pageItem"
      />
      <ContactItem v-if="pageItem.type == 'contactItem'" :item="pageItem" />
      <FormItem v-if="pageItem.type == 'formItem'" :item="pageItem" />
      <SectionsItem v-if="pageItem.type == 'sectionsItem'" :item="pageItem" />
      <GroupsItem v-if="pageItem.type == 'groupsItem'" :item="pageItem" />
      <FilesItem
        v-if="pageItem.type == 'filesItem'"
        :title="pageItem.title"
        :files="pageItem.files"
      />
      <CampItem v-if="pageItem.type == 'campItem'" :item="pageItem" />
      <LocationItem
        v-if="pageItem.type == 'locationItem'"
        :item="pageItem"
        :style="getMargins(i)"
      />
      <FaqItem v-if="pageItem.type == 'faqItem'" :item="pageItem" />
      <GroupEventsItem
        v-if="pageItem.type == 'groupEventsItem'"
        :item="pageItem"
      />
    </template>
  </PageWrapper>
</template>
<script>
import CampItem from "./CampItem.vue";
import ContactItem from "./ContactItem.vue";
import FilesItem from "./FilesItem.vue";
import FormItem from "./FormItem.vue";
import GroupsItem from "./GroupsItem.vue";
import ImageItem from "./ImageItem.vue";
import PageWrapper from "./PageWrapper.vue";
import SectionsItem from "./SectionsItem.vue";
import TextItem from "./TextItem.vue";
import LocationItem from "./LocationItem.vue";
import FaqItem from "./FaqItem.vue";
import GroupEventsItem from "./GroupEventsItem.vue";

export default {
  props: ["page"],
  data() {
    return {};
  },
  methods: {
    getMargins(i) {
      if (i === 0) {
        return "margin-top: -48px; margin-bottom: 48px;";
      } else if (i === this.page.pageItems.length - 1) {
        return "margin-bottom: -48px; margin-top: 48px;";
      } else {
        return "";
      }
    },
  },
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
    CampItem,
    LocationItem,
    FaqItem,
    GroupEventsItem,
  },
};
</script>
