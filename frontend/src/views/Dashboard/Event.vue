<template>
  <div>
    <ItemHeaderTemplate
      :title="content.title"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="events"
      backLinkTo="Events"
    >
      <template v-slot:buttons-before>
        <ActionButton
          @click="dublicateItem"
          :toolTipText="$t('dashboard.duplicateEvent')"
        >
          <font-awesome-icon :icon="icons.faCopy" class="h-6 w-6" />
        </ActionButton>
      </template>
    </ItemHeaderTemplate>
    <Card class="mt-4">
      <div class="flex flex-col space-y-2">
        <TextInput
          id="title"
          :label="$t('dashboard.title')"
          type="text"
          v-model="content.title"
          :errors="errors.title"
        />
        <SelectComponent
          id="responsible"
          :label="$t('dashboard.responsible')"
          selection="User"
          @selectUser="handleSelectUser"
          :options="users"
          :value="content.userId"
          :errors="errors.userId"
        />
        <MultipleSelect
          id="groups"
          :label="$t('dashboard.groups')"
          v-model="content.groups"
          :options="groups"
          :errors="errors.groups"
        />
        <BreakpointSpaceManager>
          <TextInput
            id="startTime"
            :label="$t('dashboard.start')"
            type="datetime-local"
            v-model="content.startTime"
            :errors="errors.startTime"
          />
          <TextInput
            id="endTime"
            :label="$t('dashboard.end')"
            type="datetime-local"
            v-model="content.endTime"
            :errors="errors.endTime"
          />
        </BreakpointSpaceManager>
        <BreakpointSpaceManager>
          <SelectComponent
            id="startLocation"
            :label="$t('dashboard.startLocation')"
            selection="StartLocation"
            @selectStartLocation="handleSelectStartLocation"
            :options="locations"
            :value="content.startLocationId"
            :errors="errors.startLocationId"
          />
          <SelectComponent
            id="endLocation"
            :label="$t('dashboard.endLocation')"
            selection="EndLocation"
            @selectEndLocation="handleSelectEndLocation"
            :options="locations"
            :value="content.endLocationId"
            :errors="errors.endLocationId"
          />
        </BreakpointSpaceManager>
        <TextInput
          id="midataLink"
          :label="$t('dashboard.midataLink')"
          type="url"
          v-model="content.externalApplicationLink"
          :errors="errors.externalApplicationLink"
        />
        <div class="flex flex-col space-y-2">
          <Editor
            id="description"
            :label="$t('dashboard.description')"
            v-model="content.description"
          />
        </div>
        <div class="flex flex-col space-y-2">
          <Editor
            id="takeWithYou"
            :label="$t('dashboard.takeWithYou')"
            v-model="content.takeWithYou"
          />
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
  faCopy,
} from "@fortawesome/free-solid-svg-icons";
import FormLabel from "../../components/admin/FormLabel.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
import MultipleSelect from "../../components/admin/MultipleSelect.vue";
import { isBefore, format, addHours } from "date-fns";
import FilesSelector from "../../components/admin/FilesSelector.vue";
import BreakpointSpaceManager from "../../components/admin/BreakpointSpaceManager.vue";
import ActionButton from "../../components/admin/ActionButton.vue";
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
    BreakpointSpaceManager,
    ActionButton,
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
        faCopy,
      },
      locations: [],
      groups: [],
      loadedKey: 0,
      users: [],
    };
  },
  watch: {
    "content.startTime": function () {
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
        this.notifyUser(this.$t("dashboard.itemUpdatedMessage"));
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
    async dublicateItem() {
      try {
        const copy = { ...this.content };
        delete copy.id;
        delete copy.createdAt;
        delete copy.updatedAt;
        const response = await this.callApi("post", `/events`, copy);
        if (response.data.id) {
          // Using nextTick to ensure the page has updated
          this.$nextTick(() => {
            this.$router.push({
              name: this.$route.name,
              params: { id: response.data.id },
            });
          });
        }
        this.notifyUser(this.$t("dashboard.itemDuplicated"));
      } catch (e) {
        this.handleErrors(e);
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
