<template>
  <div class="mx-auto max-w-7xl pt-6">
    <PageHeader :title="name">
      <template #actions>
        <ActionButton
          v-if="itemsSelected"
          @click="showDeleteModal = true"
          :toolTipText="$t('dashboard.deleteSelectedItems')"
        >
          <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6" />
        </ActionButton>
        <ActionButton
          v-if="midataSync"
          @click="syncEntity"
          :toolTipText="$t('dashboard.midataSync')"
        >
          <MiDataSync class="h-6 w-6" />
        </ActionButton>
        <ActionButton
          v-if="create"
          @click="createEntity"
          :toolTipText="$t('dashboard.createEntity')"
        >
          <font-awesome-icon :icon="icons.faPlus" class="h-6 w-6" />
        </ActionButton>
      </template>
    </PageHeader>
    <SearchField v-if="showSearch" v-model="searchString" />
    <EntityTable
      :key="tableKey"
      :entity="entity"
      @changeSelected="changeSelected"
      :columns="columns"
      :searchString="searchString"
      :cover="cover"
    />
    <ConfirmDeleteModal
      v-if="showDeleteModal"
      @close="showDeleteModal = false"
      @confirm="deleteItems"
      :message="$t('dashboard.confirmDeleteSelectedItems')"
      :title="$t('dashboard.deleteSelectedItems')"
    />
  </div>
</template>

<script>
import EntityTable from "@/components/admin/EntityTable.vue";
import PageHeader from "./PageHeader.vue";
import { faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
import MiDataSync from "@/icons/MiDataSync.vue";
import ActionButton from "./ActionButton.vue";
import SearchField from "./SearchField.vue";
import ConfirmDeleteModal from "./ConfirmDeleteModal.vue";
export default {
  props: {
    name: String,
    entity: String,
    columns: Array,
    pushAfterCreationTo: String,
    midataSync: {
      type: Boolean,
      default: false,
    },
    create: {
      type: Boolean,
      default: true,
    },
    showSearch: {
      type: Boolean,
      default: true,
    },
    cover: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    EntityTable,
    MiDataSync,
    ActionButton,
    SearchField,
    PageHeader,
    ConfirmDeleteModal,
  },
  data() {
    return {
      content: undefined,
      selected: [],
      tableKey: 0,
      searchString: undefined,
      icons: {
        faTrash,
        faPlus,
      },
      showDeleteModal: false,
    };
  },
  computed: {
    itemsSelected() {
      return this.selected.length > 0;
    },
  },
  methods: {
    changeSelected(event) {
      this.selected = event;
    },
    async deleteItems() {
      this.showDeleteModal = false;
      try {
        await Promise.all(
          this.selected.map(async (entityId) => {
            await this.callApi("delete", `${this.entity}/${entityId}`);
          }),
        );
        this.selected = [];
        this.tableKey++;
        this.notifyUser(
          this.$t("dashboard.allSelectedEntitiesWereDeleted", {
            name: this.name,
          }),
        );
      } catch (e) {
        console.log(e);
      }
    },
    async syncEntity() {
      try {
        await this.callApi("post", `${this.entity}/sync`);
        this.tableKey++;
        this.notifyUser(
          this.$t("dashboard.allEntitiesWereSynced", { name: this.name }),
        );
      } catch (e) {
        console.log(e);
      }
    },
    async createEntity() {
      try {
        this.$router.push({
          name: this.pushAfterCreationTo,
          params: { id: "new" },
        });
      } catch (e) {
        console.log(e);
      }
    },
  },
};
</script>

<style></style>
