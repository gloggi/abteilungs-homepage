<template>
    <div>
        <ItemHeaderTemplate :title="content.name" :content="content" entity="locations" backLinkTo="Locations" />
        <Card class="mt-4">
            <LocationPicker v-if="loaded" :lat="content.lat" :long="content.long" @location-selected="selectLocation"
                class="h-96 w-full" />
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
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {
        Card,
        TextInput,
        LocationPicker,
        ItemHeaderTemplate
    },
    data() {
        return {
            content: {},
            loaded: false,
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
            if (this.$route.params.id === "new") {
                return;
            }
            try {
                const response = await this.callApi(
                    "get",
                    `/locations/${this.$route.params.id}`
                );
                this.content = response.data;
                this.loaded = true;
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
        selectLocation(event) {
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