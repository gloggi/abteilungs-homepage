<template>
  <div v-if="content" :key="loadedKey">
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="forms"
      backLinkTo="Forms"
    />
    <Card class="mt-4">
      <div class="space-y-2 w-full">
        <TextInput
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
        <TextInput
          :label="$t('dashboard.email')"
          type="text"
          v-model="content.email"
          :errors="errors.email"
        />
        <TextInput
          :label="$t('dashboard.subject')"
          type="text"
          v-model="content.subject"
          :errors="errors.subject"
        />
        <SelectComponent
          :label="$t('dashboard.groups')"
          :value="content.groupId"
          :options="userGroups"
          :errors="errors.group"
          selection="Group"
          @selectGroup="handleSelectGroup"
        />
        <h2 class="font-semibold text-2xl">{{ $t("dashboard.formFields") }}</h2>
        <AddFormField
          @changeOrder="changeOrder"
          @select="addField"
          :dragging="isDragging"
          :sortKey="-1"
        />
        <template v-for="field in content.fields" :key="field.id">
          <DragItemBox
            :item="field"
            @delete="deleteField"
            @startedDragging="isDragging = true"
            @endedDragging="isDragging = false"
            v-if="field.type == 'textField'"
            :title="$t('dashboard.textfield')"
          >
            <div class="flex space-x-2">
              <TextInput
                class="w-full"
                type="text"
                v-model="field.label"
                :label="$t('dashboard.label')"
              />
              <CheckBox
                :label="$t('dashboard.required')"
                v-model="field.required"
              />
            </div>
          </DragItemBox>
          <DragItemBox
            v-if="field.type == 'textareaField'"
            :item="field"
            @delete="deleteField"
            @startedDragging="isDragging = true"
            @endedDragging="isDragging = false"
            :title="$t('dashboard.textareafield')"
          >
            <div class="flex space-x-2">
              <TextInput
                class="w-full"
                type="text"
                v-model="field.label"
                :label="$t('dashboard.label')"
              />
              <CheckBox
                :label="$t('dashboard.required')"
                v-model="field.required"
              />
            </div>
          </DragItemBox>
          <DragItemBox
            v-if="field.type == 'selectField'"
            :item="field"
            @delete="deleteField"
            @startedDragging="isDragging = true"
            @endedDragging="isDragging = false"
            :title="$t('dashboard.selectfield')"
          >
            <div class="flex space-x-2">
              <TextInput
                class="w-full"
                type="text"
                v-model="field.label"
                :label="$t('dashboard.label')"
              />
              <CheckBox
                :label="$t('dashboard.required')"
                v-model="field.required"
              />
            </div>
            <div class="space-y-2 mt-4">
              <div
                class="flex space-x-2 items-center"
                v-for="(option, i) in field.optionFields"
                :key="option.id"
              >
                <font-awesome-icon :icon="icons.faCircle" />
                <TextInput
                  :id="`selectFieldOption-${field.id}-${i}`"
                  class="w-full"
                  type="text"
                  v-model="option.name"
                  :placeholder="`${$t('dashboard.option')} ${i + 1}`"
                />
              </div>
              <div>
                <div class="flex space-x-2 items-center">
                  <font-awesome-icon :icon="icons.faCircle" />
                  <TextInput
                    class="w-full"
                    type="text"
                    @keyup="(e) => addOption(e, field)"
                    :placeholder="$t('dashboard.anotherOption')"
                  />
                </div>
              </div>
            </div>
          </DragItemBox>
          <AddFormField
            @changeOrder="changeOrder"
            @select="addField"
            :dragging="isDragging"
            :sortKey="field.sort"
          />
        </template>
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
  faGripVertical,
} from "@fortawesome/free-solid-svg-icons";
import { faCircle } from "@fortawesome/free-regular-svg-icons";
import AddFormField from "../../components/admin/AddFormField.vue";
import DragItemBox from "../../components/admin/DragItemBox.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";

export default {
  components: {
    Card,
    TextInput,
    AddFormField,
    DragItemBox,
    ItemHeaderTemplate,
    CheckBox,
    SelectComponent,
  },
  data() {
    return {
      content: {
        fields: [],
      },
      sections: undefined,
      showModal: false,
      loadedKey: 0,
      forms: [],
      dragKey: 0,
      isDragging: false,
      errors: {},
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
        faGripVertical,
        faCircle,
      },
    };
  },
  methods: {
    async addOption(event, field) {
      field.optionFields.push({ name: event.target.value });
      event.target.value = "";
      await new Promise((resolve) => setTimeout(resolve, 10));
      const textFieldToFocus = document.getElementById(
        `selectFieldOption-${field.id}-${field.optionFields.length - 1}`,
      );
      textFieldToFocus.childNodes[1].focus();
    },
    changeOrder(newField) {
      const fieldIndex = this.content.fields.findIndex(
        (f) => f.id == newField.id,
      );
      this.content.fields[fieldIndex] = newField;
      this.updateForm();
    },
    addField(field) {
      this.content.fields.push(field);
      this.updateForm();
    },
    deleteField(idAndType) {
      this.content.fields = this.content.fields.filter(
        (f) => `${f.id}${f.type}` !== idAndType,
      );
      this.updateForm();
    },
    async getForm() {
      try {
        if (this.$route.params.id === "new") {
          return;
        }
        const response = await this.callApi(
          "get",
          `/forms/${this.$route.params.id}`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updateForm() {
      try {
        await this.callApi(
          "put",
          `/forms/${this.$route.params.id}`,
          this.content,
        );
        this.notifyUser("The Form was updated");
      } catch (e) {
        console.log(e);
      }
      this.getForm();
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    async handleSelectGroup(value) {
      this.content.groupId = value;
    },
  },
  async created() {
    await this.getForm();
  },
};
</script>

<style></style>
