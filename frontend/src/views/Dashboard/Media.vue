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
      <div
        v-if="loading"
        class="absolute inset-0 z-10 flex items-center justify-center bg-white/50 backdrop-blur-sm"
      >
        <div
          class="h-10 w-10 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
        ></div>
      </div>

      <MediaGrid :files="files" @open="openFile" @delete="confirmDelete" />
    </div>

    <div class="mt-6">
      <PaginationNav
        :total-items="total"
        :items-per-page="perPage"
        :page-number="currentPage"
        @go-to-page="changePage"
      />
    </div>

    <Modal v-if="showModal" @close="closeModal" size="5xl">
      <MediaDetail
        v-if="selectedFile"
        :file="selectedFile"
        :cacheBust="cacheBust"
        @update="updateFile"
        @delete="confirmDelete(selectedFile)"
        @replace="replaceFile"
      />
    </Modal>

    <Modal v-if="showUploadModal" @close="showUploadModal = false">
      <h2 class="text-xl font-bold mb-4">{{ $t("dashboard.uploadFile") }}</h2>
      <DragAndDropUpload @uploadedFile="onUploaded" />
    </Modal>
  </div>
</template>

<script>
import SearchField from "../../components/admin/SearchField.vue";
import PageHeader from "../../components/admin/PageHeader.vue";
import MediaGrid from "../../components/admin/media/MediaGrid.vue";
import MediaDetail from "../../components/admin/media/MediaDetail.vue";
import PaginationNav from "../../components/admin/PaginationNav.vue";
import DragAndDropUpload from "../../components/admin/DragAndDropUpload.vue";
import Modal from "../../components/admin/Modal.vue";
import { debounce } from "lodash";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import ButtonComponent from "../../components/admin/ButtonComponent.vue";

export default {
  components: {
    SearchField,
    PageHeader,
    MediaGrid,
    MediaDetail,
    PaginationNav,
    DragAndDropUpload,
    Modal,
    FontAwesomeIcon,
    ButtonComponent,
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
      selectedFile: null,
      cacheBust: Date.now(),
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
  },
  created() {
    this.getFiles();
  },
  methods: {
    async getFiles(page = 1) {
      this.loading = true;
      try {
        const params = {
          per_page: this.perPage,
          page: page,
        };

        if (this.search) {
          params.search = this.search;
        }

        if (this.filter && this.extensionMap[this.filter]) {
          params.extensions = this.extensionMap[this.filter];
        }

        const response = await this.callApi("get", "/files", null, { params });
        this.files = response.data.data;
        this.currentPage = response.data.currentPage;
        this.lastPage = response.data.lastPage;
        this.total = response.data.total;
        this.perPage = response.data.perPage;
      } catch (e) {
        console.error(e);
        this.notifyUser(this.$t("dashboard.noFilesFound"), "error");
      } finally {
        this.loading = false;
      }
    },

    onSearch: debounce(function (val) {
      this.search = val;
      this.getFiles(1);
    }, 300),

    onFilter(val) {
      this.filter = val;
      this.getFiles(1);
    },

    changePage(page) {
      if (page >= 1 && page <= this.lastPage) {
        this.getFiles(page);
      }
    },

    onUploaded() {
      this.getFiles();
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
      }, 300); // Clear after animation
    },

    async confirmDelete(file) {
      if (confirm(this.$t("dashboard.confirmDelete"))) {
        await this.deleteFile(file);
      }
    },

    async deleteFile(file) {
      try {
        await this.callApi("delete", `/files/${file.id}`);
        await this.getFiles();
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
        await this.getFiles();
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
        await this.getFiles();

        this.cacheBust = Date.now();
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
