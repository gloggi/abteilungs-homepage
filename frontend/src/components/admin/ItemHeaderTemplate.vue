<template>
  <Card class="flex justify-between items-center mb-2">
    <h2 class="font-extrabold text-4xl">{{ title }}</h2>
  </Card>
  <div class="flex justify-between mb-2">
    <router-link :to="{ name: backLinkTo }">
      <ActionButton>
        <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6" />
      </ActionButton>
    </router-link>
    <div class="flex space-x-2">
      <slot name="buttons-before"></slot>
      <ActionButton v-if="!noDelete" @click="deleteItem">
        <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6" />
      </ActionButton>
      <ActionButton @click="updateItem">
        <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6" />
      </ActionButton>
      <slot name="buttons-after"></slot>
    </div>
  </div>
</template>
<script>
import Card from "../../components/admin/Card.vue";
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
    Card,
    ActionButton,
  },
  props: ["title", "content", "backLinkTo", "entity", "noDelete"],
  emits: ["errors", "clearErrors"],
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
        this.notifyUser(this.$t("dashboard.itemDeleted"));
        this.$router.push({ name: this.backLinkTo });
      } catch (e) {
        console.log(e);
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
        this.notifyUser(this.$t("dashboard.itemCreated"));
      } catch (e) {
        if (e.response.status === 422) {
          this.$emit("errors", e.response.data.errors);
        } else if (e.response.status === 403) {
          this.notifyUser(this.$t("dashboard.noPermission"));
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

        this.notifyUser(this.$t("dashboard.itemUpdated"));
      } catch (e) {
        this.handleErrors(e);
      }
    },
    handleErrors(e) {
      if (e.response.status === 422) {
        this.$emit("errors", e.response.data.errors);
      } else if (e.response.status === 403) {
        this.notifyUser(this.$t("dashboard.noPermission"), true);
      }
    },
  },
};
</script>
