<template>
  <Card v-if="imageItem" class="relative">
      <div class="absolute right-0 top-0">
          <button @click="deleteItem" class="border-l p-1 border-b border-gray-200 rounded-bl-lg">
            <TrashIcon class="h-6 w-6 text-gray-500" />
            </button>
      </div>
        <div class="grid grid-cols-2 gap-2 mt-3">
          <div
            class="relative"
            v-for="image in imageItem.images"
            :key="image['@id']"
          >
            <button class="absolute top-1 right-1" @click="()=>removeImage(image['@id'])">
              <XIcon class="h-6 w-6 text-gray-500" />
            </button>
            <img
              :src="image.contentUrl"
              class="rounded-lg object-cover h-full"
            />
          </div>
        </div>
      <div class="flex justify-end mt-2">
        <Button @click="openMediaModal"
            >Add Images</Button
          >
      </div>
      </Card>
      <MediaModal
      v-if="showModal"
      :preselected="preSelectedImages"
      @selectImages="handleImages"
      @close="() => (showModal = false)"
    />
</template>

<script>
import MediaModal from '../MediaModal.vue';
import {
  XIcon, TrashIcon
} from "@heroicons/vue/24/solid";
import Button from '../Button.vue';
import Card from '../Card.vue';
export default {
  components: { MediaModal, XIcon, Button, Card, TrashIcon },
    props: ["item"],
    emits: ["updatePage"],
  data() {
    return {
      imageItem: undefined,
      showModal: false,
      preSelectedImages: undefined
    };
  },
  methods: {
    async update() {
      try {
        await this.callApi("put", `${this.imageItem["@id"]}`, this.imageItem);
      } catch (e) {
        console.log(e);
      }
    },
    async deleteItem() {
      try {
        await this.callApi("delete", `${this.imageItem["@id"]}`);
        this.$emit("updatePage")

      } catch (e) {
        console.log(e);
      }
    },
    removeImage(iri){
        this.imageItem.images = this.imageItem.images.filter(image=>image['@id']!=iri)
        this.update();
    },
    openMediaModal() {
      this.activeItemIri = this.imageItem['@id'];
      this.preSelectedImages = this.imageItem.images.map(image=>image['@id'])
      this.showModal = true;
    },
    async handleImages(event){
        this.imageItem.images =event
        await this.update()
        this.$emit("updatePage")
    }
  },
  mounted() {
    this.imageItem = {...this.item}
  },

}
</script>

<style>

</style>