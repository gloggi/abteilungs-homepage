<template>
  <AddItemButton
    :items="fields"
    :dragging="dragging"
    :sortKey="sortKey"
    :dragText="$t('dashboard.dropPageItemHere')"
    :addText="$t('dashboard.clickToAddPageItem')"
    :modalTitle="$t('dashboard.pageItems')"
    @select="$emit('select', $event)"
    @changeOrder="$emit('changeOrder', $event)"
  />
</template>

<script>
import { markRaw } from "vue";
import AddItemButton from "./AddItemButton.vue";
import TextItem from "../../assets/PageItems/TextItem.svg?component";
import ImageItem from "../../assets/PageItems/ImageItem.svg?component";
import FormItem from "../../assets/PageItems/FormItem.svg?component";
import FilesItem from "../../assets/PageItems/FilesItem.svg?component";
import ContactItem from "../../assets/PageItems/ContactItem.svg?component";
import GroupsItem from "../../assets/PageItems/GroupsItem.svg?component";
import SectionsItem from "../../assets/PageItems/SectionsItem.svg?component";
import CampItem from "../../assets/PageItems/CampItem.svg?component";
import LocationItem from "../../assets/PageItems/LocationItem.svg?component";
import FaqItem from "../../assets/PageItems/FaqItem.svg?component";
import GroupEventsItem from "../../assets/PageItems/GroupEventsItem.svg?component";

export default {
  components: {
    AddItemButton,
  },
  props: ["sortKey", "dragging"],
  emits: ["select", "changeOrder"],
  data() {
    return {
      fields: [
        {
          name: this.$t("dashboard.text"),
          type: "textItem",
          component: markRaw(TextItem),
        },
        {
          name: this.$t("dashboard.image"),
          type: "imageItem",
          component: markRaw(ImageItem),
        },
        {
          name: this.$t("dashboard.form"),
          type: "formItem",
          component: markRaw(FormItem),
        },
        {
          name: this.$t("dashboard.files"),
          type: "filesItem",
          component: markRaw(FilesItem),
        },
        {
          name: this.$t("dashboard.contacts"),
          type: "contactItem",
          component: markRaw(ContactItem),
        },
        {
          name: this.$t("dashboard.groups"),
          type: "groupsItem",
          component: markRaw(GroupsItem),
        },
        {
          name: this.$t("dashboard.sections"),
          type: "sectionsItem",
          component: markRaw(SectionsItem),
        },
        {
          name: this.$t("dashboard.camps"),
          type: "campItem",
          component: markRaw(CampItem),
        },
        {
          name: this.$t("dashboard.location"),
          type: "locationItem",
          component: markRaw(LocationItem),
        },
        {
          name: this.$t("dashboard.faq"),
          type: "faqItem",
          component: markRaw(FaqItem),
        },
        {
          name: this.$t("dashboard.groupEvents"),
          type: "groupEventsItem",
          component: markRaw(GroupEventsItem),
        },
      ],
    };
  },
};
</script>

