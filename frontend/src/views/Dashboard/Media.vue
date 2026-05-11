<template>
  <div class="mx-auto max-w-7xl pt-6">
    <PageHeader :title="$t('dashboard.media')">
      <template #actions>
        <ButtonComponent @click="showUploadModal = true">
          <font-awesome-icon :icon="icons.faPlus" class="mr-2 h-4 w-4" />
          {{ $t("dashboard.uploadFile") }}
        </ButtonComponent>
      </template>
    </PageHeader>

    <SearchField
      :modelValue="search"
      @update:modelValue="onSearch"
      :filter="filter"
      @update:filter="onFilter"
      :filter-options="filterOptions"
      :placeholder="$t('dashboard.searchFiles')"
    />

    <div class="relative min-h-[400px]">
      <MediaGrid
        v-if="files.length > 0 || !loading"
        :files="files"
        @open="openFile"
        @delete="confirmDelete"
      />
      <div
        v-if="loading"
        class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6"
        :class="{ 'mt-4': files.length > 0 }"
      >
        <div
          v-for="i in files.length === 0 ? 12 : 6"
          :key="`skeleton-${i}`"
          class="flex flex-col rounded-xl border border-gray-200 bg-white shadow-xs animate-pulse"
        >
          <div class="aspect-square w-full rounded-t-xl bg-white"></div>
          <div class="flex flex-col p-3">
            <div class="h-4 w-3/4 rounded-md bg-gray-200"></div>
            <div class="mt-3 flex items-center justify-between">
              <div class="h-3 w-10 rounded-md bg-gray-200"></div>
              <div class="h-3 w-12 rounded-md bg-gray-200"></div>
            </div>
          </div>
        </div>
      </div>

      <div ref="sentinel" class="h-1"></div>
    </div>

    <MediaDetailModal
      v-if="showModal && selectedFile"
      :file="selectedFile"
      :cacheBust="cacheBust"
      @close="closeModal"
      @update="updateFile"
      @delete="confirmDelete(selectedFile)"
      @replace="replaceFile"
    />

    <Modal v-if="showUploadModal" @close="showUploadModal = false">
      <h2 class="text-xl font-bold mb-4">{{ $t("dashboard.uploadFile") }}</h2>
      <DragAndDropUpload @uploadedFile="onUploaded" />
    </Modal>

    <ConfirmDeleteModal
      v-if="showDeleteModal"
      @close="showDeleteModal = false"
      @confirm="executeDelete"
      :message="$t('dashboard.confirmDelete')"
    />
  </div>
</template>

<script>
import SearchField from "../../components/admin/SearchField.vue";
import PageHeader from "../../components/admin/PageHeader.vue";
import MediaGrid from "../../components/admin/media/MediaGrid.vue";
import MediaDetailModal from "../../components/admin/media/MediaDetailModal.vue";
import DragAndDropUpload from "../../components/admin/DragAndDropUpload.vue";
import Modal from "../../components/admin/Modal.vue";
import { debounce } from "lodash";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import ButtonComponent from "../../components/admin/ButtonComponent.vue";
import ConfirmDeleteModal from "../../components/admin/ConfirmDeleteModal.vue";

export default {
  components: {
    SearchField,
    PageHeader,
    MediaGrid,
    MediaDetailModal,
    DragAndDropUpload,
    Modal,
    FontAwesomeIcon,
    ButtonComponent,
    ConfirmDeleteModal,
  },
  data() {
    return {
      files: [],
      currentPage: 1,
      lastPage: 1,
      total: 0,
      perPage: 54,
      search: "",
      filter: "",
      loading: false,
      showModal: false,
      showUploadModal: false,
      showDeleteModal: false,
      selectedFile: null,
      fileToDelete: null,
      cacheBust: Date.now(),
      observer: null,
      extensionMap: {
        image: "jpg,jpeg,png,gif,webp,svg,bmp,tiff,ico",
        document: "pdf,doc,docx,txt,rtf,odt",
        spreadsheet: "xls,xlsx,csv,ods",
        audio: "mp3,wav,ogg,m4a",
        video: "mp4,mov,avi,webm,mkv",
        archive: "zip,rar,7z,tar,gz",
      },
      icons: {
        faPlus,
      },
    };
  },
  computed: {
    filterOptions() {
      return [
        { value: "", label: this.$t("dashboard.allTypes") },
        { value: "image", label: this.$t("dashboard.images") },
        { value: "document", label: this.$t("dashboard.documents") },
        { value: "spreadsheet", label: this.$t("dashboard.spreadsheets") },
        { value: "audio", label: this.$t("dashboard.audio") },
        { value: "video", label: this.$t("dashboard.video") },
        { value: "archive", label: this.$t("dashboard.archives") },
      ];
    },
    hasMorePages() {
      return this.currentPage <= this.lastPage;
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.setupObserver();
    });
  },
  beforeUnmount() {
    if (this.observer) {
      this.observer.disconnect();
    }
  },
  async created() {
    await this.loadMore();
  },
  methods: {
    resetAndLoad() {
      this.currentPage = 1;
      this.files = [];
      this.total = 0;
      this.lastPage = 1;
      this.loadMore();
    },
    async loadMore() {
      if (this.loading || !this.hasMorePages) return;

      this.loading = true;
      try {
        const params = {
          per_page: this.perPage,
          page: this.currentPage,
        };

        if (this.search) {
          params.search = this.search;
        }

        if (this.filter && this.extensionMap[this.filter]) {
          params.extensions = this.extensionMap[this.filter];
        }

        const response = await this.callApi("get", "/files", null, { params });
        if (response.status == 204) {
          this.currentPage = 1;
          this.files = [];
          this.total = 0;
          this.lastPage = 1;
          this.loading = false;
          return;
        }

        const newItems = response.data.data;
        this.files = [...this.files, ...newItems];
        this.lastPage = response.data.lastPage;
        this.total = response.data.total;
        this.perPage = response.data.perPage;
        this.currentPage++;
      } catch (e) {
        console.error(e);
        this.notifyUser(this.$t("dashboard.noFilesFound"), "error");
      } finally {
        this.loading = false;
      }
    },

    setupObserver() {
      this.observer = new IntersectionObserver(
        (entries) => {
          if (entries[0].isIntersecting && !this.loading && this.hasMorePages) {
            this.loadMore();
          }
        },
        {
          rootMargin: "200px",
        },
      );
      if (this.$refs.sentinel) {
        this.observer.observe(this.$refs.sentinel);
      }
    },

    onSearch: debounce(function (val) {
      this.search = val;
      this.resetAndLoad();
    }, 300),

    onFilter(val) {
      this.filter = val;
      this.resetAndLoad();
    },

    onUploaded() {
      this.resetAndLoad();
      this.notifyUser(this.$t("dashboard.uploaded"));
      this.showUploadModal = false;
    },

    openFile(file) {
      this.selectedFile = file;
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
      setTimeout(() => {
        this.selectedFile = null;
      }, 300);
    },

    confirmDelete(file) {
      this.fileToDelete = file;
      this.showDeleteModal = true;
    },

    executeDelete() {
      this.showDeleteModal = false;
      if (this.fileToDelete) {
        this.deleteFile(this.fileToDelete);
        this.fileToDelete = null;
      }
    },

    async deleteFile(file) {
      try {
        await this.callApi("delete", `/files/${file.id}`);
        this.files = this.files.filter((f) => f.id !== file.id);
        this.total--;
        this.notifyUser(this.$t("dashboard.itemDeleted"));
        if (
          this.showModal &&
          this.selectedFile &&
          this.selectedFile.id === file.id
        ) {
          this.closeModal();
        }
      } catch (e) {
        console.error(e);
        this.notifyUser("Error deleting file", "error");
      }
    },

    async updateFile(updatedFile) {
      try {
        await this.callApi("put", `/files/${updatedFile.id}`, {
          name: updatedFile.name,
          category: updatedFile.category,
        });

        const index = this.files.findIndex((f) => f.id === updatedFile.id);
        if (index !== -1) {
          this.files[index] = { ...this.files[index], ...updatedFile };
        }

        this.notifyUser(this.$t("dashboard.itemUpdated"));
        this.selectedFile = { ...this.selectedFile, ...updatedFile };
      } catch (e) {
        console.error(e);
        this.notifyUser("Error updating file", "error");
      }
    },

    async replaceFile(file) {
      try {
        const formData = new FormData();
        formData.append("file", file, file.name);
        formData.append("category", "test");

        await this.callApi("post", `/files/${this.selectedFile.id}`, formData);

        // As the controller doesn't return the updated file object, we just trigger a full reload
        // to ensure we have the correct thumbnail and file path.
        this.resetAndLoad();

        this.cacheBust = Date.now();
        this.notifyUser(this.$t("dashboard.itemUpdated"));
      } catch (e) {
        console.error(e);
        this.notifyUser("Error replacing file", "error");
      }
    },
  },
};
</script>

<style></style>
