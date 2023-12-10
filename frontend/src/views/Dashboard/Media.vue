<template>
    <DragAndDropUpload @uploadedFile="getMedia" />
    <div class="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-4 mt-2" :key="listKey">
        <button v-for="file in content" target="_blank" :key="file.id" @click="openFile(file)">
            <div class="bg-gray-50 rounded-lg h-full">
                <img :src="`${backendURL}${file.thumbnail}`" class="w-full rounded-lg object-cover aspect-square" />
            </div>
        </button>
    </div>
    <Modal v-if="showModal" @close="showModal = false">
       <div v-if="content" class="flex h-full p-3 space-x-2">
        <div  class="flex justify-center items-center w-2/3">
            <img v-if="isImage()"  :src="`${backendURL}${selectedFile.path}`" class="w-auto" style="max-height: 90vh;" />
            <object v-if="selectedFile.extension=='pdf'" :data="`${backendURL}${selectedFile.path}`" height="550px"  type="application/pdf" style="aspect-ratio: 1 / 1.42;"
            />
        </div>
        <div class="w-1/3">
            <div class="flex flex-col space-y-2 pt-8 w-full">
                <CopyField label="URL" :value="`${backendURL}${selectedFile.path}`" />
                <CopyField label="Thumbnail URL" :value="`${backendURL}${selectedFile.thumbnail}`" />
                <TextInput label="Category" v-model="selectedFile.category" /> 
                
            </div>
            <div class="flex justify-between pt-5">
                <div class="font-cursive text-gray-400">Created at {{ formatDateTime(selectedFile.createdAt) }}</div>
             <button @click="deleteFile"> <font-awesome-icon :icon="icons.faTrash" class="w-5 h-5 text-red-400" /> </button>
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
import { faTrash } from "@fortawesome/free-solid-svg-icons";

export default {
    components: { DragAndDropUpload, Modal, CopyField, TextInput },
    data() {
        return {
            content: undefined,
            listKey: 0,
            showModal: false,
            selectedFile: undefined,
            icons: {
                faTrash,
            },
        };
    },
    methods: {
        isImage() {
            const imageTypes = ["png", "jpeg", "gif"];
            return imageTypes.includes(this.selectedFile.extension);
        },
        async getMedia() {
            try {
                const response = await this.callApi("get", "/files");
                console.log(response);
                this.content = response.data.data;
                this.listKey++;
            } catch (e) {
                console.log(e);
            }
        },
        async deleteFile() {
            await this.callApi("delete", `/files/${this.selectedFile.id}`);
            await this.getMedia();
            this.showModal = false;
            this.selectedFile = undefined;
            
        },
        openFile(file) {
            this.selectedFile = file;
            this.showModal = true;
        },
    },
    async created() {
        await this.getMedia();
    },
};
</script>

<style></style>
