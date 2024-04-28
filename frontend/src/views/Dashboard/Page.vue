<template>
  <div v-if="content">
    <ItemHeaderTemplate
      :title="content.title"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="pages"
      backLinkTo="Pages"
      @updatedItem="handleUpdatedItem"
    >
      <template v-slot:buttons-before>
        <ActionButton @click="dublicateItem">
          <font-awesome-icon :icon="icons.faCopy" class="h-6 w-6" />
        </ActionButton>
      </template>
      <template v-slot:buttons-after>
        <ActionButton @click="visitPage">
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
      <div class="flex flex-col md:flex-row items-center">
        <div v-if="!isGroupPage" class="w-full flex flex-col">
          <FormLabel>{{ $t("dashboard.route") }}</FormLabel>
          <div v-if="routeInEdit" class="flex flex-row items-center space-x-2">
            <div>
              <div class="flex flex-row items-center">
                <p class="text-lg text-gray-900 font-semibold">
                  {{ baseUrl }}
                </p>
                <input
                  id="route"
                  type="text"
                  class="p-0 text-lg font-semibold rounded focus:outline-none focus:shadow-outline focus:ring-gray-900 focus:border-gray-900"
                  v-model="content.route"
                />
              </div>
              <div v-if="errors.route" class="text-red-400 text-xs">
                {{ errors.route.join(" ") }}
              </div>
            </div>
            <ActionButton @click="saveRoute" :reverse="true" size="small">
              <font-awesome-icon :icon="icons.faCheck" class="size-4" />
            </ActionButton>
          </div>
          <div v-else class="flex flex-row items-center space-x-2">
            <router-link
              v-if="content.route"
              class="text-lg text-gray-900 hover:text-gray-600 font-semibold"
              :to="{ name: 'Home2', params: { path: content.route } }"
            >
              {{ `${baseUrl}${this.content.route || ""}` }}
            </router-link>
            <ActionButton
              @click="routeInEdit = true"
              :reverse="true"
              :toolTipText="$t('dashboard.editRoute')"
              size="small"
            >
              <font-awesome-icon :icon="icons.faPen" class="size-4" />
            </ActionButton>
          </div>
          <InfoField :info="$t('dashboard.infoRootDirectory')" />
        </div>
        <CheckBox
          class="mt-2 md:ml-2 text-nowrap"
          :label="$t('dashboard.isGroupPage')"
          v-model="isGroupPage"
        />
      </div>
      <SelectComponent
        v-if="isGroupPage"
        id="group"
        :label="$t('dashboard.group')"
        :options="groups"
        selection="Group"
        @selectGroup="($event) => (content.groupId = $event)"
        :value="content.groupId"
        :errors="errors.groupId"
      />
      <CheckBox
        :label="$t('dashboard.showBigHeader')"
        v-model="content.bigHeader"
      />

      <FormLabel>{{ $t("dashboard.headerImages") }}</FormLabel>
      <BannerImageSelector
        :key="loadedKey"
        :info="$t('dashboard.infoAspectRatio')"
        :item="content"
        @changeImages="changeHeaderImages"
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
        :key="i"
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
        :key="i"
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
        :key="i"
      />
      <FormItem
        v-if="pageItem.type == 'formItem'"
        :boxTitle="$t('dashboard.formItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="i"
        @changeForm="changeFormItem"
        :item="pageItem"
      />
      <ContactItem
        v-if="pageItem.type == 'contactItem'"
        :boxTitle="$t('dashboard.contactItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="i"
        :item="pageItem"
      />
      <GroupsItem
        v-if="pageItem.type == 'groupsItem'"
        :boxTitle="$t('dashboard.groupsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="i"
        :item="pageItem"
      />
      <SectionsItem
        v-if="pageItem.type == 'sectionsItem'"
        :boxTitle="$t('dashboard.sectionsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="i"
        :item="pageItem"
      />
      <CampItem
        v-if="pageItem.type == 'campItem'"
        :boxTitle="$t('dashboard.campsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeCamp="changeCampItem"
        :key="i"
        :item="pageItem"
      />
      <LocationItem
        v-if="pageItem.type == 'locationItem'"
        :boxTitle="$t('dashboard.locationItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :key="i"
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
        :key="i"
        :item="pageItem"
      />
      <GroupEventsItem
        v-if="pageItem.type == 'groupEventsItem'"
        :boxTitle="$t('dashboard.groupEventsItem')"
        @delete="deleteItem"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        @changeGroupEvents="changeGroupEvents"
        :key="i"
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
import CheckBox from "../../components/admin/CheckBox.vue";
import Card from "../../components/admin/Card.vue";
import AddPageItem from "../../components/admin/AddPageItem.vue";
import {
  faEye,
  faCopy,
  faPen,
  faCheck,
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
import InfoField from "../../components/admin/InfoField.vue";
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
    SectionsItem,
    CheckBox,
    FilesItem,
    CampItem,
    LocationItem,
    FaqItem,
    SelectComponent,
    GroupEventsItem,
    ActionButton,
    InfoField,
  },
  data() {
    return {
      content: {
        files: [],
        pageItems: [],
      },
      loadedKey: 0,
      errors: {},
      activeItemIri: undefined,
      preSelectedImages: undefined,
      isDragging: false,
      icons: {
        faEye,
        faCopy,
        faPen,
        faCheck,
      },
      groups: [],
      isGroupPage: false,
      routeInEdit: false,
    };
  },
  async created() {
    await this.getPage();
    await this.getGroups();
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
    async getPage() {
      try {
        if (this.contentId === "new") {
          return;
        }
        const response = await this.callApi("get", `/pages/${this.contentId}`);
        this.content = response.data;
        this.isGroupPage = !!this.content.groupId;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updatePage() {
      try {
        await this.callApi("put", `/pages/${this.content.id}`, this.content);
        this.getPage();
        this.notifyUser("The page has been successfully updated");
      } catch (e) {
        console.log(e);
      }
    },
    async getGroups() {
      try {
        const response = await this.callApi("get", "/groups");
        this.groups = response.data.data;
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
      const files = event.files.files;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "imageItem",
      );
      this.content.pageItems[itemIndex].files = files;
    },
    changeFilesItem(event) {
      const pageItemId = event.id;
      const title = event.title;
      const files = event.files;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "filesItem",
      );
      this.content.pageItems[itemIndex].title = title;
      this.content.pageItems[itemIndex].files = files;
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
    changeHeaderImages(event) {
      this.content.files = event.files;
    },
    changeCampItem(event) {
      const pageItemId = event.id;
      const groupId = event.groupId;
      const itemIndex = this.content.pageItems.findIndex(
        (p) => p.id == pageItemId && p.type == "campItem",
      );
      this.content.pageItems[itemIndex].groupId = groupId;
    },
    slugyfy(text) {
      return kebabCase(text);
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    visitPage() {
      if (!this.content.route) {
        this.$router.push({ name: "Home" });
        return;
      }
      if (this.isGroupPage) {
        const groupRoute = this.groups.find(
          (g) => g.id == this.content.groupId,
        )?.route;
        this.$router.push({ name: "GroupPage", params: { id: groupRoute } });
        return;
      }
      this.$router.push({
        name: "Home2",
        params: { path: this.content.route },
      });
    },
    async dublicateItem() {
      try {
        const copy = { ...this.content };
        delete copy.id;
        delete copy.createdAt;
        delete copy.updatedAt;
        delete copy.groupId;
        copy.pageItems.forEach((p) => {
          delete p.id;
          delete p.createdAt;
          delete p.updatedAt;
        });
        copy.title = `${copy.title} (Kopie)`;
        copy.route = `${copy.route}-kopie`;
        const response = await this.callApi("post", `/pages`, copy);
        if (response.data.id) {
          // Using nextTick to ensure the page has updated
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
    saveRoute() {
      this.content.route = this.content.route;
      this.routeInEdit = false;
    },
    handleUpdatedItem() {
      this.routeInEdit = false;
    },
  },
  watch: {
    "content.title"(newVal) {
      if (this.contentId == "new") {
        this.content.route = this.slugyfy(newVal);
      }
    },
    $route: {
      imediade: true,
      handler: function () {
        this.content = {};
        this.getPage();
      },
    },
  },
};
</script>

<style></style>
