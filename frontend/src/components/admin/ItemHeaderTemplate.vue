<template>
  <PageHeader :title="title" class="pt-6">
    <template #actions>
      <router-link :to="{ name: backLinkTo }">
        <ActionButton>
          <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6" />
        </ActionButton>
      </router-link>
      <slot name="buttons-before"></slot>
      <ActionButton
        v-if="!noDelete"
        @click="deleteItem"
        :toolTipText="$t('dashboard.deleteItem')"
      >
        <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6" />
      </ActionButton>
      <ActionButton
        v-if="!noUpdate"
        @click="updateItem"
        :toolTipText="$t('dashboard.saveChanges')"
      >
        <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6" />
      </ActionButton>
      <slot name="buttons-after"></slot>
    </template>
  </PageHeader>
</template>
<script>
import PageHeader from "../../components/admin/PageHeader.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
  faCopy,
} from "@fortawesome/free-solid-svg-icons";
import ActionButton from "./ActionButton.vue";
export default {
  components: {
    PageHeader,
    ActionButton,
  },
  props: [
    "title",
    "content",
    "backLinkTo",
    "entity",
    "noDelete",
    "noUpdate",
    "modelName",
  ],
  emits: ["errors", "clearErrors", "updatedItem"],
  data() {
    return {
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
        faCopy,
      },
      isDragging: false,
    };
  },
  computed: {
    contentId() {
      return this.$route.params.id;
    },
  },
  methods: {
    async deleteItem() {
      if (this.contentId === "new") {
        this.$router.push({ name: this.backLinkTo });
        return;
      }
      try {
        await this.callApi("delete", `/${this.entity}/${this.contentId}`);
        if (this.modelName) {
          this.notifyModel(this.modelName, "delete");
        } else {
          this.notifyUser(this.$t("dashboard.itemDeleted"));
        }
        this.$router.push({ name: this.backLinkTo });
      } catch (e) {
        if (this.modelName) {
          this.notifyModel(this.modelName, "delete", true);
        } else {
          console.log(e);
        }
      }
    },
    async createItem() {
      this.$emit("clearErrors");
      try {
        const response = await this.callApi(
          "post",
          `/${this.entity}`,
          this.content,
        );
        if (response.data.id) {
          this.$router.push({
            name: this.$route.name,
            params: { id: response.data.id },
          });
        }
        if (this.modelName) {
          this.notifyModel(this.modelName, "create");
        } else {
          this.notifyUser(this.$t("dashboard.itemCreated"));
        }
      } catch (e) {
        if (e.response.status === 422) {
          this.$emit("errors", e.response.data.errors);
        } else if (e.response.status === 403) {
          this.notifyUser(this.$t("dashboard.noPermission"), true);
        } else if (this.modelName) {
          this.notifyModel(this.modelName, "create", true);
        }
      }
    },
    async updateItem() {
      if (this.contentId === "new") {
        await this.createItem();
        return;
      }
      try {
        await this.callApi(
          "put",
          `/${this.entity}/${this.contentId}`,
          this.content,
        );
        this.$emit("updatedItem");

        if (this.modelName) {
          this.notifyModel(this.modelName, "update");
        } else {
          this.notifyUser(this.$t("dashboard.itemUpdated"));
        }
      } catch (e) {
        this.handleErrors(e);
      }
    },
    handleErrors(e) {
      if (e.response.status === 422) {
        this.$emit("errors", e.response.data.errors);
      } else if (e.response.status === 403) {
        this.notifyUser(this.$t("dashboard.noPermission"), true);
      } else if (this.modelName) {
        this.notifyModel(this.modelName, "update", true);
      }
    },
  },
};
</script>
