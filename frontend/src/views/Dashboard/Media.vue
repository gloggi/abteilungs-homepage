<template>
  <DragAndDropUpload @uploadedFile="getMedia" />
  <div
    class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2 py-2"
    :key="listKey"
  >
    <button
      v-for="file in content"
      target="_blank"
      :key="file.id"
      @click="openFile(file)"
    >
      <div class="bg-gray-50 rounded-lg w-full">
        <img
          :src="`${backendURL}${file.thumbnail}?cb=${this.cacheBust}`"
          class="w-full rounded-lg object-contain p-1 roundd-lg aspect-square"
        />
      </div>
    </button>
  </div>
  <Modal v-if="showModal" @close="showModal = false">
    <div v-if="content" class="flex flex-col md:flex-row h-full p-3 space-x-2">
      <div
        id="fileContainer"
        :key="currentSelectionKey"
        class="flex justify-center items-center w-full md:w-2/3"
      >
        <img
          v-if="isImage()"
          :src="`${backendURL}${selectedFile.path}?cb=${this.cacheBust}`"
          class="w-auto"
          style="max-height: 90vh"
        />
        <object
          v-else-if="selectedFile.extension == 'pdf'"
          :data="`${backendURL}${selectedFile.path}?cb=${this.cacheBust}`"
          height="550px"
          type="application/pdf"
          style="aspect-ratio: 1 / 1.42"
        />
        <video v-else-if="selectedFile.extension == 'mp4'" controls>
          <source
            :src="`${backendURL}${selectedFile.path}?cb=${this.cacheBust}`"
            type="video/mp4"
          />
        </video>
        <audio v-else-if="selectedFile.extension == 'mp3'" controls>
          <source
            :src="`${backendURL}${selectedFile.path}?cb=${this.cacheBust}`"
            type="audio/mpeg"
          />
        </audio>
        <img
          v-else
          :src="`${backendURL}${selectedFile.thumbnail}`"
          class="w-auto"
          style="max-height: 90vh"
        />
      </div>
      <div class="w-full md:w-1/3">
        <div class="flex justify-end w-full space-x-2 pt-2 md:pt-0">
          <ActionButton
            @click="deleteFile"
            :reverse="true"
            :toolTipText="$t('dashboard.deleteFile')"
          >
            <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6" />
          </ActionButton>
          <ActionButton
            @click="updateFile"
            :reverse="true"
            :toolTipText="$t('dashboard.updateFile')"
          >
            <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6" />
          </ActionButton>
        </div>
        <div class="flex flex-col space-y-2 md:pt-8 w-full">
          <TextInput
            id="name"
            :label="$t('dashboard.name')"
            v-model="selectedFile.name"
          />
          <CopyField
            id="extension"
            :label="$t('dashboard.extension')"
            :value="selectedFile.extension"
          />
          <CopyField
            id="url"
            :label="$t('dashboard.url')"
            :value="`${backendURL}${selectedFile.path}`"
          />
          <CopyField
            id="thumbnailUrl"
            :label="$t('dashboard.thumbnailUrl')"
            :value="`${backendURL}${selectedFile.thumbnail}`"
          />
          <div>
            <FormLabel>
              {{ $t("dashboard.replaceFile") }}
            </FormLabel>
            <DragAndDropField @droppedFile="replaceFile" />
          </div>
        </div>
        <div class="flex justify-between pt-5">
          <div class="font-cursive text-gray-400">
            {{ $t("dashboard.createdAt") }}
            {{ formatDateTime(selectedFile.createdAt) }}
          </div>
        </div>
      </div>
    </div>
  </Modal>
</template>

<script>
import CopyField from "../../components/admin/CopyField.vue";
import DragAndDropUpload from "../../components/admin/DragAndDropUpload.vue";
import Modal from "../../components/admin/Modal.vue";
import TextInput from "../../components/admin/TextInput.vue";
import { faTrash, faArrowsRotate } from "@fortawesome/free-solid-svg-icons";
import ActionButton from "../../components/admin/ActionButton.vue";
import DragAndDropField from "../../components/admin/DragAndDropField.vue";
import FormLabel from "../../components/admin/FormLabel.vue";

export default {
  components: {
    DragAndDropUpload,
    Modal,
    CopyField,
    TextInput,
    ActionButton,
    DragAndDropField,
    FormLabel,
  },
  data() {
    return {
      content: undefined,
      listKey: 0,
      showModal: false,
      selectedFile: undefined,
      currentSelectionKey: 0,
      cacheBust: Date.now(),
      icons: {
        faTrash,
        faArrowsRotate,
      },
    };
  },
  methods: {
    isImage() {
      const imageTypes = [
        "png",
        "jpeg",
        "jpg",
        "gif",
        "svg",
        "bmp",
        "webp",
        "tiff",
        "ico",
      ];
      return imageTypes.includes(this.selectedFile.extension.toLowerCase());
    },
    async getMedia() {
      try {
        const response = await this.callApi("get", "/files");
        this.content = response.data.data;
        this.listKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async deleteFile() {
      try {
        await this.callApi("delete", `/files/${this.selectedFile.id}`);
        await this.getMedia();
        this.notifyUser("File deleted");
        this.showModal = false;
        this.selectedFile = undefined;
      } catch (e) {
        console.log(e);
      }
    },
    async updateFile() {
      try {
        await this.callApi("put", `/files/${this.selectedFile.id}`, {
          name: this.selectedFile.name,
          category: this.selectedFile.category,
        });
        await this.getMedia();
        this.notifyUser("File updated");
      } catch (e) {
        console.log(e);
      }
    },
    openFile(file) {
      this.selectedFile = file;
      this.showModal = true;
    },
    async replaceFile(file) {
      try {
        const formData = new FormData();
        formData.append("file", file, file.name);
        formData.append("category", "test");
        await this.callApi("post", `/files/${this.selectedFile.id}`, formData);
        await this.getMedia();
        this.notifyUser("File replaced");
        this.cacheBust = Date.now();
      } catch (e) {
        console.log(e);
      }
    },
  },
  async created() {
    await this.getMedia();
  },
};
</script>

<style></style>
