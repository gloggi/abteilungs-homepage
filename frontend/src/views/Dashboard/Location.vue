<template>
  <div>
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="locations"
      backLinkTo="Locations"
    />
    <Card class="mt-4">
      <LocationPicker
        :key="loadedKey"
        :lat="content.lat"
        :long="content.long"
        @location-selected="selectLocation"
        class="h-96 w-full"
      />
      <div class="flex flex-col space-y-2">
        <TextInput
          id="name"
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
        <div class="flex space-x-2 w-full">
          <TextInput
            id="lat"
            class="w-full"
            :label="$t('dashboard.latitudeDD')"
            type="number"
            v-model="content.lat"
            :errors="errors.lat"
          />
          <TextInput
            id="long"
            class="w-full"
            :label="$t('dashboard.longitudeDD')"
            type="number"
            v-model="content.long"
            :errors="errors.long"
          />
        </div>
        <TextInput
          id="lv95"
          :label="$t('dashboard.swissCoordinatesLV95')"
          type="text"
          v-model="lv95"
        />
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import LocationPicker from "../../components/admin/LocationPicker.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import { project, unproject } from "swissgrid";
export default {
  components: {
    Card,
    TextInput,
    LocationPicker,
    ItemHeaderTemplate,
  },
  data() {
    return {
      content: {},
      lv95: undefined,
      loadedKey: 0,
      errors: {},
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
      },
    };
  },
  watch: {
    "content.lat": function () {
      if (this.content.lat && this.content.long) {
        this.lv95 = this.formatLV95(
          project([
            parseFloat(this.content.long),
            parseFloat(this.content.lat),
          ]),
        );
      }
    },
    "content.long": function () {
      if (this.content.lat && this.content.long) {
        this.lv95 = this.formatLV95(
          project([
            parseFloat(this.content.long),
            parseFloat(this.content.lat),
          ]),
        );
      }
    },
    lv95: function (newVal, oldVal) {
      if (oldVal && oldVal != newVal && this.content.lat && this.content.long) {
        let [x, y] = this.lv95.split("/");
        x = x.replace(/\s/g, "");
        y = y.replace(/\s/g, "");
        const [long, lat] = unproject([parseFloat(x), parseFloat(y)]);
        this.content.lat = lat;
        this.content.long = long;
      }
    },
  },
  methods: {
    async getLocation() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/locations/${this.$route.params.id}`,
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
          this.content,
        );
        this.notifyUser(this.$t("dashboard.itemUpdatedMessage"));
      } catch (e) {
        console.log(e);
      }
    },
    selectLocation(event) {
      this.content.lat = event.lat;
      this.content.long = event.long;
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    formatLV95(lv95) {
      return lv95
        .map((num) =>
          new Intl.NumberFormat("de-CH")
            .format(Math.round(num))
            .replace(/’/g, " "),
        )
        .join(" / ");
    },
  },
  async created() {
    await this.getLocation();
  },
};
</script>

<style></style>
