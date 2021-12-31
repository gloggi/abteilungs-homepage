<template>
    <div
        @dragover.prevent
        @dragenter="isDragging = true"
        @dragleave="isDragging = false"
        @drop.prevent
        @drop="dragFile"
        :class="` rounded-lg ${
            isDragging
                ? 'border-dashed bg-gray-500 border-2'
                : 'bg-white border'
        }  border-gray-50 text-center p-5`"
    >
        Drag and Drop your Files to upload
    </div>
</template>

<script>
export default {
    data() {
        return {
            files: [],
            isDragging: false,
        };
    },
    methods: {
        async addMedia() {
            try {
                const formData = new FormData();
                formData.append(
                    "file",
                    this.files[0],
                    this.files[0].name
                );
                const response = await this.callApi("post", "/media_objects", formData);
                console.log(response);
                this.files = []
                this.$emit("uploadedFile", true)
            } catch (e) {
                console.log(e);
            }
        },
        uploadFile(e) {
            this.files = e.target.files;
        },
        dragFile(e) {
            this.isDragging = false;
            this.files = e.dataTransfer.files;
            this.addMedia()
        },
    },
};
</script>

<style></style>
