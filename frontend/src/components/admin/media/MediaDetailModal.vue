<template>
  <Modal @close="$emit('close')" size="5xl" :noContentOverflow="true">
    <div class="flex flex-col md:flex-row gap-6 h-[75vh] md:h-[70vh]">
      <Card
        class="flex shrink-0 items-center justify-center overflow-hidden bg-gray-50/50 md:w-2/3 h-48 md:h-full"
      >
        <img
          v-if="isImage()"
          :src="`${backendURL}${file.path}?cb=${cacheBust}`"
          class="max-h-full w-auto object-contain shadow-xs rounded-md"
        />
        <object
          v-else-if="file.extension == 'pdf'"
          :data="`${backendURL}${file.path}?cb=${cacheBust}`"
          class="h-full w-full shadow-xs rounded-md"
          type="application/pdf"
        />
        <video
          v-else-if="file.extension == 'mp4'"
          controls
          class="max-h-full w-full shadow-xs rounded-md"
        >
          <source
            :src="`${backendURL}${file.path}?cb=${cacheBust}`"
            type="video/mp4"
          />
        </video>
        <audio
          v-else-if="file.extension == 'mp3'"
          controls
          class="w-full max-w-md"
        >
          <source
            :src="`${backendURL}${file.path}?cb=${cacheBust}`"
            type="audio/mpeg"
          />
        </audio>
        <img
          v-else
          :src="`${backendURL}${file.thumbnail}`"
          class="max-h-full w-auto rounded-md"
        />
      </Card>
      <div class="flex flex-col w-full md:w-1/3 min-h-0">
        <div class="flex-1 overflow-y-auto pr-2">
          <div class="space-y-6">
            <div class="space-y-4">
              <h3 class="font-medium text-gray-900 border-b pb-2">
                {{ $t("dashboard.fileDetails") }}
              </h3>

              <TextInput
                id="name"
                :label="$t('dashboard.name')"
                v-model="localFile.name"
              />

              <div class="grid grid-cols-2 gap-4">
                <CopyField
                  id="extension"
                  :label="$t('dashboard.extension')"
                  :value="localFile.extension"
                />
                <div class="flex flex-col">
                  <span class="text-xs font-semibold text-gray-500 uppercase">{{
                    $t("dashboard.size")
                  }}</span>
                  <span class="mt-1 text-sm text-gray-900">{{
                    formatFilesize(file.size)
                  }}</span>
                </div>
              </div>

              <CopyField
                id="url"
                :label="$t('dashboard.url')"
                :value="`${backendURL}${file.path}`"
              />

              <CopyField
                id="thumbnailUrl"
                :label="$t('dashboard.thumbnailUrl')"
                :value="`${backendURL}${file.thumbnail}`"
              />
            </div>

            <div class="space-y-4">
              <h3 class="font-medium text-gray-900 border-b pb-2">
                {{ $t("dashboard.replaceFile") }}
              </h3>
              <DragAndDropField @droppedFile="$emit('replace', $event)" />
            </div>
          </div>

          <div
            class="mt-6 pt-4 text-xs text-center text-gray-400 font-mono border-t"
          >
            {{ $t("dashboard.createdAt") }}
            {{ formatDateTime(file.createdAt) }}
          </div>
        </div>
      </div>
    </div>

    <template #footer>
      <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
        <ButtonComponent
          variant="destructive"
          size="icon"
          @click="$emit('delete')"
          :title="$t('dashboard.deleteFile')"
        >
          <font-awesome-icon :icon="icons.trash" class="h-4 w-4" />
        </ButtonComponent>
        <ButtonComponent @click="saveChanges" :title="$t('dashboard.save')">
          <font-awesome-icon :icon="icons.save" class="mr-2 h-4 w-4" />
          <span>{{ $t("dashboard.save") }}</span>
        </ButtonComponent>
      </div>
    </template>
  </Modal>
</template>

<script>
import Modal from "../Modal.vue";
import Card from "../Card.vue";
import TextInput from "../TextInput.vue";
import CopyField from "../CopyField.vue";
import DragAndDropField from "../DragAndDropField.vue";
import ButtonComponent from "../ButtonComponent.vue";
import { format as formatDate } from "date-fns";
import { faTrash, faSave } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "MediaDetailModal",
  components: {
    Modal,
    Card,
    TextInput,
    CopyField,
    DragAndDropField,
    ButtonComponent,
    FontAwesomeIcon,
  },
  emits: ["close", "update", "delete", "replace"],
  props: {
    file: {
      type: Object,
      required: true,
    },
    cacheBust: [Number, String],
  },
  data() {
    return {
      localFile: { ...this.file },
      icons: {
        trash: faTrash,
        save: faSave,
      },
    };
  },
  watch: {
    file(newVal) {
      this.localFile = { ...newVal };
    },
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
      return imageTypes.includes(this.file.extension.toLowerCase());
    },
    saveChanges() {
      this.$emit("update", this.localFile);
    },
    formatDateTime(date) {
      if (!date) return "";
      try {
        return formatDate(new Date(date), "dd.MM.yyyy HH:mm");
      } catch {
        return date;
      }
    },
    formatFilesize(size) {
      if (!size) return "";
      const i = Math.floor(Math.log(size) / Math.log(1024));
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        " " +
        ["B", "kB", "MB", "GB", "TB"][i]
      );
    },
  },
};
</script>
