<template>
  <div>
    <ItemHeaderTemplate
      :title="content.title"
      :dublicate="true"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="events"
      backLinkTo="Events"
    />
    <Card class="mt-4">
      <div class="flex flex-col space-y-2">
        <TextInput
          :label="$t('dashboard.title')"
          type="text"
          v-model="content.title"
          :errors="errors.title"
        />
        <SelectComponent
          :label="$t('dashboard.responsible')"
          selection="User"
          @selectUser="handleSelectUser"
          :options="users"
          :value="content.userId"
          :errors="errors.userId"
        />
        <TextInput
          :label="$t('dashboard.start')"
          type="datetime-local"
          v-model="content.startTime"
          :errors="errors.startTime"
        />
        <TextInput
          :label="$t('dashboard.end')"
          type="datetime-local"
          v-model="content.endTime"
          :errors="errors.endTime"
        />
        <MultipleSelect
          :label="$t('dashboard.groups')"
          v-model="content.groups"
          :options="groups"
        />
        <SelectComponent
          :label="$t('dashboard.startLocation')"
          selection="StartLocation"
          @selectStartLocation="handleSelectStartLocation"
          :options="locations"
          :value="content.startLocationId"
          :errors="errors.startLocationId"
        />
        <SelectComponent
          :label="$t('dashboard.endLocation')"
          selection="EndLocation"
          @selectEndLocation="handleSelectEndLocation"
          :options="locations"
          :value="content.endLocationId"
          :errors="errors.endLocationId"
        />
        <TextInput
          :label="$t('dashboard.midataLink')"
          type="url"
          v-model="content.externalApplicationLink"
          :errors="errors.externalApplicationLink"
        />
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.description") }}</FormLabel>
          <Editor v-model="content.description" />
        </div>
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.takeWithYou") }}</FormLabel>
          <Editor v-model="content.takeWithYou" />
        </div>
        <div class="flex flex-col space-y-2">
          <FormLabel>{{ $t("dashboard.files") }}</FormLabel>
          <FilesSelector
            :key="loadedKey"
            :item="{ files: content.files }"
            @changeFiles="changeFiles"
          />
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import { isBefore, format, addHours, subHours } from "date-fns";
import FilesSelector from "../../components/admin/FilesSelector.vue";
export default {
  components: {
    Card,
    TextInput,
    SelectComponent,
    ItemHeaderTemplate,
    FormLabel,
    Editor,
    MultipleSelect,
    FilesSelector,
  },
  data() {
    return {
      content: {
        groups: [],
      },
      errors: {},
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
      },
      locations: [],
      groups: [],
      loadedKey: 0,
      users: [],
    };
  },
  watch: {
    "content.startTime": function (val) {
      if (
        !this.content.endTime ||
        !isBefore(
          new Date(this.content.startTime),
          new Date(this.content.endTime),
        )
      ) {
        let endTime = new Date(this.content.startTime);
        endTime = addHours(endTime, 3);
        endTime = format(endTime, "yyyy-MM-dd'T'HH:mm");
        this.content.endTime = endTime;
      }
    },
  },
  methods: {
    async getEvent() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/events/${this.$route.params.id}`,
        );
        this.content = response.data;
        if (this.content.groups) {
          this.content.groups = this.content.groups.map((g) => g.id);
        }
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
          this.content,
        );
        this.$store.dispatch(
          "notification/notify",
          "The Event was successfully updated!",
        );
      } catch (e) {
        console.log(e);
      }
    },
    selectEvent(event) {
      this.content.lat = event.lat;
      this.content.long = event.long;
    },
    async getLocations() {
      try {
        const response = await this.callApi("get", `/locations`);
        this.locations = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    async getGroups() {
      try {
        const response = await this.callApi("get", `/groups`);
        this.groups = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    handleSelectStartLocation(event) {
      this.content.startLocationId = event;
    },
    handleSelectEndLocation(event) {
      this.content.endLocationId = event;
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    changeFiles(event) {
      this.content.files = event.files;
    },
    handleSelectUser(event) {
      console.log("selected", event);
      this.content.userId = event;
    },
    async getUsers() {
      try {
        const response = await this.callApi("get", `/users`);
        this.users = response.data.data.map((u) => {
          return {
            id: u.id,
            name: `${u.nickname} (${u.firstname} ${u.lastname})`,
          };
        });
      } catch (e) {
        console.log(e);
      }
    },
  },
  async created() {
    await this.getEvent();
    await this.getLocations();
    await this.getGroups();
    await this.getUsers();
  },
};
</script>

<style></style>
