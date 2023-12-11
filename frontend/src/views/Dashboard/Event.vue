<template>
    <div v-if="content">
        <Card class="flex justify-between items-center mb-2">
            <h2 class="font-extrabold text-4xl">{{ content.title }}</h2>
        </Card>
        <div class="flex justify-between mb-2">
            <router-link :to="{ name: 'Events' }">
                <button class="rounded-l-lg bg-white p-1">
                    <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6 text-gray-500" />
                </button>
            </router-link>
            <div>
                <button @click="deletePage" class="bg-white p-1 border-r border-l border-gray-200">
                    <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
                </button>
                <button class="rounded-r-lg bg-white p-1" @click="updateEvent">
                    <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
                </button>
            </div>
        </div>
        <Card class="mt-4">
            <LocationPicker v-if="false" :lat="content.lat" :long="content.long" @event-selected="selectEvent" class="h-96 w-full" />
            <div class="flex flex-col space-y-2">
                <TextInput label="Title" type="text" v-model="content.title" />
                <TextInput label="Start" type="datetime-local" v-model="content.startTime" />
                <TextInput label="End" type="datetime-local" v-model="content.endTime" />
                <Select label="Group" selection="Group" @selectGroup="handleSelectGroup" :options="groups" :value="content.groupId" />
                <Select label="Start Location" selection="StartLocation" @selectStartLocation="handleSelectStartLocation" :options="locations" :value="content.startLocationId" />
                <Select label="End Location" selection="EndLocation" @selectEndLocation="handleSelectEndLocation" :options="locations" :value="content.endLocationId" />
            </div>

        </Card>
    </div>
</template>
  
<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import LocationPicker from "../../components/admin/LocationPicker.vue";
import Select from "../../components/admin/Select.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {
        Card,
        TextInput,
        LocationPicker,
        Select
    },
    data() {
        return {
            content: undefined,
            icons: {
                faArrowsRotate,
                faChevronLeft,
                faTrash,
                faPlus
            },
            locations: [],
            groups: [],
        };
    },
    methods: {
        async getEvent() {
            try {
                const response = await this.callApi(
                    "get",
                    `/events/${this.$route.params.id}`
                );
                this.content = response.data;
                this.loadedKey++;
            } catch (e) {
                console.log(e);
            }
        },
        async updateEvent() {
            try {
                await this.callApi(
                    "put",
                    `/events/${this.$route.params.id}`,
                    this.content
                );
                this.$store.dispatch(
                    "notification/notify",
                    "The Event was successfully updated!"
                );
            } catch (e) {
                console.log(e);
            }
        },
        selectEvent(event){
            this.content.lat = event.lat;
            this.content.long = event.long;
        },
        async getLocations() {
            try {
                const response = await this.callApi(
                    "get",
                    `/locations`
                );
                this.locations = response.data.data;
            } catch (e) {
                console.log(e);
            }
        },
        async getGroups() {
            try {
                const response = await this.callApi(
                    "get",
                    `/groups`
                );
                this.groups = response.data.data;
            } catch (e) {
                console.log(e);
            }
        },
        handleSelectStartLocation(event){
            this.content.startLocationId = event;
        },
        handleSelectEndLocation(event){
            this.content.endLocationId = event;
        },
        handleSelectGroup(event){
            this.content.groupId = event;
        },

    },
    async created() {
        await this.getEvent();
        await this.getLocations();
        await this.getGroups();

    },
};
</script>
  
<style></style>