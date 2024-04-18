<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card class="space-y-2">
      <div class="">
        <div
          class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2"
        >
          <TextInput
            class="w-full md:w-3/4"
            :label="$t('dashboard.title')"
            v-model.lazy="titleValue"
          />
          <SelectComponent
            :key="loadedKey"
            class="w-full md:w-1/4 whitespace-nowrap"
            :label="$t('dashboard.showSectionOrGroupLogo')"
            :value="groupOrSectionId"
            :options="groupsAndSections"
            @selectLogo="selectLogo"
            selection="Logo"
          />
        </div>
        <Editor v-model="bodyValue" />
      </div>
    </Card>
  </DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import CheckBox from "../CheckBox.vue";
import DragItemBox from "../DragItemBox.vue";
import Editor from "../Editor/Editor.vue";
import FormLabel from "../FormLabel.vue";
import TextInput from "../TextInput.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import SelectComponent from "../SelectComponent.vue";
export default {
  components: {
    TextInput,
    Editor,
    Card,
    DragItemBox,
    FormLabel,
    CheckBox,
    SelectComponent,
  },
  props: ["title", "body", "item", "boxTitle", "sectionId", "groupId"],
  emits: [
    "updatePage",
    "update:title",
    "update:body",
    "update:sectionId",
    "update:groupId",
    "delete",
    "startedDragging",
    "endedDragging",
  ],
  data() {
    return {
      textItem: undefined,
      loadedKey: 0,
      groupOrSectionId: undefined,
      icons: {
        faTrash,
      },
    };
  },
  methods: {
    selectLogo(id) {
      const name = this.groupsAndSections.find((obj) => obj.id === id)?.name;
      if (!name) {
        this.groupIdValue = null;
        this.sectionIdValue = null;
        return;
      }
      this.groupIdValue = this.groups.find((group) => group.name === name)?.id;
      this.sectionIdValue = this.sections.find(
        (section) => section.name === name,
      )?.id;
    },
    async getGroups() {
      await this.$store.dispatch("groups/fetchGroups");
    },
    async getSections() {
      await this.$store.dispatch("sections/fetchSections");
    },
    prepareGroupOrSectionId() {
      if (this.sectionId) {
        const sectionName = this.sections.find(
          (section) => section.id === this.sectionId,
        )?.name;
        this.groupOrSectionId = this.groupsAndSections.find(
          (item) => item.name === sectionName,
        )?.id;
      } else if (this.groupId) {
        const groupName = this.groups.find(
          (group) => group.id === this.groupId,
        )?.name;
        this.groupOrSectionId = this.groupsAndSections.find(
          (item) => item.name === groupName,
        )?.id;
      }
    },
  },
  computed: {
    titleValue: {
      get() {
        return this.title;
      },
      set(value) {
        this.$emit("update:title", value);
      },
    },
    bodyValue: {
      get() {
        return this.body;
      },
      set(value) {
        this.$emit("update:body", value);
      },
    },
    sectionIdValue: {
      get() {
        return this.sectionId;
      },
      set(value) {
        this.$emit("update:sectionId", value);
      },
    },
    groupIdValue: {
      get() {
        return this.groupId;
      },
      set(value) {
        this.$emit("update:groupId", value);
      },
    },
    groups() {
      return this.$store.state.groups.groups;
    },
    sections() {
      return this.$store.state.sections.sections;
    },
    groupsAndSections() {
      let id = 1;
      return this.sections
        .concat(this.groups)
        .map((obj) => ({ ...obj, id: id++ }));
    },
  },
  async created() {
    await this.getGroups();
    await this.getSections();
    this.prepareGroupOrSectionId();
    this.loadedKey++;
  },
};
</script>

<style></style>
