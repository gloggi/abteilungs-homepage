<template>
  <div v-if="content">
    <ItemHeaderTemplate
      :title="content.title"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="blogposts"
      backLinkTo="BlogPosts"
      @updatedItem="handleUpdatedItem"
      :modelName="$t('dashboard.blogPost')"
    >
      <template v-slot:buttons-before>
        <ActionButton @click="dublicateItem">
          <font-awesome-icon :icon="icons.faCopy" class="h-6 w-6" />
        </ActionButton>
      </template>
      <template v-slot:buttons-after>
        <ActionButton @click="visitPost">
          <font-awesome-icon :icon="icons.faEye" class="h-6 w-6" />
        </ActionButton>
      </template>
    </ItemHeaderTemplate>
    <Card class="space-y-2">
      <TextInput
        id="title"
        :label="$t('dashboard.title')"
        v-model="content.title"
        :errors="errors.title"
      />
      <div class="flex flex-col md:flex-row items-start gap-4">
        <SlugInput
          :label="$t('dashboard.slug')"
          :prefix="baseUrl + 'blog/'"
          v-model="content.slug"
          :errors="errors.slug"
          :toolTipText="$t('dashboard.editSlug')"
          ref="slugInput"
        />
        <TextInput
          type="date"
          :label="$t('dashboard.publishedAt')"
          v-model="content.publishedAt"
          :errors="errors.publishedAt"
        />
        <CheckBox
          class="md:text-nowrap"
          :label="$t('dashboard.active')"
          v-model="content.active"
          :errors="errors.active"
        />
      </div>
      <TagInput
        :label="$t('dashboard.tags')"
        v-model="content.tags"
        :allowCreate="true"
        class="mb-4"
      />
      <FormLabel>{{ $t("dashboard.headerImages") }}</FormLabel>
      <BannerImageSelector
        :key="loadedKey"
        :info="$t('dashboard.infoAspectRatio')"
        :item="content"
        @changeImages="changeHeaderImages"
      />
      <FormLabel>{{ $t("dashboard.previewImage") }}</FormLabel>
      <BannerImageSelector
        :key="loadedKey + '_preview'"
        :info="$t('dashboard.infoPreviewImage')"
        :item="{
          id: content.id,
          files: content.previewImage ? [content.previewImage] : [],
        }"
        @changeImages="changePreviewImage"
      />
    </Card>
    <AddPageItem
      @changeOrder="changeOrder"
      @select="addItem"
      :dragging="isDragging"
      :sortKey="-1"
    />
    <div v-for="(pageItem, i) in content.pageItems" :key="i">
      <TextItem
        v-if="pageItem.type == 'textItem'"
        :boxTitle="$t('dashboard.textItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`textItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
        v-model:title="pageItem.title"
        v-model:body="pageItem.body"
        v-model:sectionId="pageItem.sectionId"
        v-model:groupId="pageItem.groupId"
      />
      <ImageItem
        v-if="pageItem.type == 'imageItem'"
        :boxTitle="$t('dashboard.imageItem')"
        @changeImages="changeImageItem"
        :item="pageItem"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`imageItem-${pageItem.id || pageItem.tempId}`"
      />
      <FilesItem
        v-if="pageItem.type == 'filesItem'"
        :boxTitle="$t('dashboard.filesItem')"
        @changeFiles="changeFilesItem"
        v-model:title="pageItem.title"
        :item="pageItem"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`filesItem-${pageItem.id || pageItem.tempId}`"
      />
      <FormItem
        v-if="pageItem.type == 'formItem'"
        :boxTitle="$t('dashboard.formItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`formItem-${pageItem.id || pageItem.tempId}`"
        @changeForm="changeFormItem"
        :item="pageItem"
      />
      <ContactItem
        v-if="pageItem.type == 'contactItem'"
        :boxTitle="$t('dashboard.contactItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`contactItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <GroupsItem
        v-if="pageItem.type == 'groupsItem'"
        :boxTitle="$t('dashboard.groupsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`groupsItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <SectionsItem
        v-if="pageItem.type == 'sectionsItem'"
        :boxTitle="$t('dashboard.sectionsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`sectionsItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <CampItem
        v-if="pageItem.type == 'campItem'"
        :boxTitle="$t('dashboard.campsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeCamp="changeCampItem"
        :key="`campItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <LocationItem
        v-if="pageItem.type == 'locationItem'"
        :boxTitle="$t('dashboard.locationItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="`locationItem-${pageItem.id || pageItem.tempId}`"
        @changeLocation="changeLocationItem"
        :item="pageItem"
      />
      <FaqItem
        v-if="pageItem.type == 'faqItem'"
        :boxTitle="$t('dashboard.faqItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeFaq="changeFaqItem"
        :key="`faqItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <GroupEventsItem
        v-if="pageItem.type == 'groupEventsItem'"
        :boxTitle="$t('dashboard.groupEventsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeGroupEvents="changeGroupEvents"
        :key="`groupEventsItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <BlogPostsItem
        v-if="pageItem.type == 'blogPostsItem'"
        :boxTitle="$t('dashboard.blogPostsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeBlogPostsItem="changeBlogPostsItem"
        :key="`blogPostsItem-${pageItem.id || pageItem.tempId}`"
        :item="pageItem"
      />
      <AddPageItem
        @changeOrder="changeOrder"
        @select="addItem"
        :dragging="isDragging"
        :sortKey="pageItem.sort"
      />
    </div>
  </div>
</template>

<script>
import TextInput from "../../components/admin/TextInput.vue";
import TagInput from "../../components/ui/TagInput.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import Card from "../../components/admin/Card.vue";
import AddPageItem from "../../components/admin/AddPageItem.vue";
import {
  faEye,
  faCopy,
} from "@fortawesome/free-solid-svg-icons";
import TextItem from "../../components/admin/PageItems/TextItem.vue";
import ImageItem from "../../components/admin/PageItems/ImageItem.vue";
import { kebabCase } from "lodash";

import FormItem from "../../components/admin/PageItems/FormItem.vue";
import ContactItem from "../../components/admin/PageItems/ContactItem.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import BannerImageSelector from "../../components/admin/BannerImageSelector.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
import GroupsItem from "../../components/admin/PageItems/GroupsItem.vue";
import SectionsItem from "../../components/admin/PageItems/SectionsItem.vue";
import FilesItem from "../../components/admin/PageItems/FilesItem.vue";
import CampItem from "../../components/admin/PageItems/CampItem.vue";
import LocationItem from "../../components/admin/PageItems/LocationItem.vue";
import FaqItem from "../../components/admin/PageItems/FaqItem.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import GroupEventsItem from "../../components/admin/PageItems/GroupEventsItem.vue";
import ActionButton from "../../components/admin/ActionButton.vue";
import { nanoid } from "nanoid";
import BlogPostsItem from "../../components/admin/PageItems/BlogPostsItem.vue";
import SlugInput from "../../components/admin/SlugInput.vue";

export default {
  components: {
    TextInput,
    TagInput,
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
    SectionsItem,
    CheckBox,
    FilesItem,
    CampItem,
    LocationItem,
    FaqItem,
    SelectComponent,
    GroupEventsItem,
    ActionButton,
    BlogPostsItem,
    SlugInput,
  },
  data() {
    return {
      content: {
        pageItems: [],
        files: [],
      },
      loadedKey: 0,
      errors: {},
      isDragging: false,
      icons: {
        faEye,
        faCopy,
      },
    };
  },
  async created() {
    await this.getBlogPost();
  },
  computed: {
    contentId() {
      return this.$route.params.id;
    },
    baseUrl() {
      return `${window.location.protocol}//${window.location.hostname}${
        window.location.port ? ":" + window.location.port : ""
      }/`;
    },
  },
  methods: {
    async getBlogPost() {
      try {
        if (this.contentId === "new") {
          this.content = {
            pageItems: [],
            active: true,
            publishedAt: new Date().toISOString().slice(0, 10),
            tags: [],
          };
          return;
        }
        const response = await this.callApi(
          "get",
          `/blogposts/${this.contentId}`,
        );
        this.content = response.data;
        if (this.content.publishedAt) {
          this.content.publishedAt = this.content.publishedAt.slice(0, 10);
        }
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    addItem(field) {
      field.tempId = nanoid();
      this.content.pageItems.push(field);
      this.content.pageItems = this.content.pageItems.sort(
        (a, b) => a.sort - b.sort,
      );
      this.content.pageItems.forEach((p, i) => (p.sort = i));
    },
    changeOrder(newItem) {
      this.content.pageItems = this.content.pageItems.filter(
        (p) => p.id !== newItem.id || p.tempId !== newItem.tempId,
      );
      this.content.pageItems.push(newItem);
      this.content.pageItems = this.content.pageItems.sort(
        (a, b) => a.sort - b.sort,
      );
      this.content.pageItems.forEach((p, i) => (p.sort = i));
    },
    deleteItem(item) {
      this.content.pageItems = this.content.pageItems.filter(
        (p) => p.type !== item.type || p.sort !== item.sort,
      );
    },
    changeImageItem(event) {
      const pageItemId = event.id;
      const pageItemIdTempId = event.tempId;
      const files = event.files.files;
      const itemIndex = this.content.pageItems.findIndex(
        (p) =>
          p.id == pageItemId &&
          p.tempId == pageItemIdTempId &&
          p.type == "imageItem",
      );
      this.content.pageItems[itemIndex].files = files;
    },
    changeFilesItem(event) {
      const pageItemId = event.id;
      const title = event.title;
      const files = event.files;
      const viewMode = event.viewMode;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "filesItem",
      );
      this.content.pageItems[itemIndex].title = title;
      this.content.pageItems[itemIndex].files = files;
      this.content.pageItems[itemIndex].view_mode = viewMode;
    },
    changeFormItem(event) {
      const pageItemId = event.id;
      const formId = event.formId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "formItem",
      );

      this.content.pageItems[itemIndex].formId = formId;
    },
    changeFaqItem(event) {
      const pageItemId = event.id;
      const faqId = event.faqId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "faqItem",
      );

      this.content.pageItems[itemIndex].faqId = faqId;
    },
    changeLocationItem(event) {
      const pageItemId = event.id;
      const locationId = event.locationId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "locationItem",
      );

      this.content.pageItems[itemIndex].locationId = locationId;
    },
    changeGroupEvents(event) {
      const pageItemId = event.id;
      const groupId = event.groupEventsId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "groupEventsItem",
      );

      this.content.pageItems[itemIndex].groupId = groupId;
    },
    changeCampItem(event) {
      const pageItemId = event.id;
      const groupId = event.groupId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "campItem",
      );
      this.content.pageItems[itemIndex].groupId = groupId;
    },
    changeBlogPostsItem(event) {
      const pageItemId = event.id;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "blogPostsItem",
      );
      this.content.pageItems[itemIndex] = {
        ...this.content.pageItems[itemIndex],
        ...event,
      };
    },
    changeHeaderImages(event) {
      this.content.files = event.files;
    },
    changePreviewImage(event) {
      const files = event.files;
      if (files && files.length > 0) {
        this.content.previewImage = files[0];
        this.content.previewImageId = files[0].id;
      } else {
        this.content.previewImage = null;
        this.content.previewImageId = null;
      }
    },
    slugyfy(text) {
      return kebabCase(text);
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    async dublicateItem() {
      try {
        const copy = { ...this.content };
        delete copy.id;
        delete copy.createdAt;
        delete copy.updatedAt;
        copy.pageItems.forEach((p) => {
          delete p.id;
          delete p.createdAt;
          delete p.updatedAt;
        });
        copy.title = `${copy.title} (Kopie)`;
        copy.slug = `${copy.slug}-kopie`;
        const response = await this.callApi("post", `/blogposts`, copy);
        if (response.data.id) {
          this.$nextTick(() => {
            this.$router.push({
              name: this.$route.name,
              params: { id: response.data.id },
            });
          });
        }
        this.notifyUser(this.$t("dashboard.itemDuplicated"));
      } catch (e) {
        this.handleErrors(e);
      }
    },
    handleUpdatedItem() {
      if (this.$refs.slugInput) {
        this.$refs.slugInput.cancelEditing();
      }
    },
    visitPost() {
      if (!this.content.slug) {
        this.$router.push({ name: "PublicBlogList" });
        return;
      }
      this.$router.push({
        name: "PublicBlogPost",
        params: { slug: this.content.slug },
      });
    },
  },
  watch: {
    "content.title"(newVal) {
      if (this.contentId == "new") {
        this.content.slug = this.slugyfy(newVal);
      }
    },
    $route: {
      immediate: true,
      handler: function () {
        this.content = { pageItems: [] };
        this.getBlogPost();
      },
    },
  },
};
</script>
