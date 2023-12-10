<template>
    <div v-if="content">
        <Card class="flex justify-between items-center mb-2">
            <h2 class="font-extrabold text-4xl">{{ content.name }}</h2>
        </Card>
        <div class="flex justify-between mb-2">
            <router-link :to="{ name: 'Locations' }">
                <button class="rounded-l-lg bg-white p-1">
                    <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6 text-gray-500" />
                </button>
            </router-link>
            <div>
                <button @click="deletePage" class="bg-white p-1 border-r border-l border-gray-200">
                    <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
                </button>
                <button class="rounded-r-lg bg-white p-1" @click="updateLocation">
                    <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
                </button>
            </div>
        </div>
        <Card class="mt-4">
            <LocationPicker v-if="content" :lat="content.lat" :long="content.long" @location-selected="selectLocation" class="h-96 w-full" />
            <div class="flex flex-col space-y-2">
                <TextInput label="Name" type="text" v-model="content.name" />
                <TextInput label="Latitude" type="text" v-model="content.lat" />
                <TextInput label="Longitude" type="text" v-model="content.long" />
            </div>

        </Card>
    </div>
</template>
  
<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import LocationPicker from "../../components/admin/LocationPicker.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {
        Card,
        TextInput,
        LocationPicker
    },
    data() {
        return {
            content: undefined,
            icons: {
                faArrowsRotate,
                faChevronLeft,
                faTrash,
                faPlus
            }
        };
    },
    methods: {
        async getLocation() {
            try {
                const response = await this.callApi(
                    "get",
                    `/locations/${this.$route.params.id}`
                );
                this.content = response.data;
                this.loadedKey++;
            } catch (e) {
                console.log(e);
            }
        },
        async updateLocation() {
            try {
                await this.callApi(
                    "put",
                    `/locations/${this.$route.params.id}`,
                    this.content
                );
                this.$store.dispatch(
                    "notification/notify",
                    "The Location was successfully updated!"
                );
            } catch (e) {
                console.log(e);
            }
        },
        selectLocation(event){
            this.content.lat = event.lat;
            this.content.long = event.long;
        },

    },
    async created() {
        await this.getLocation();

    },
};
</script>
  
<style></style>