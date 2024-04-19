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
    <Card>
      <div class="space-y-2 w-full">
        <TextInput
          id="name"
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
        <TextInput
          id="email"
          :label="$t('dashboard.email')"
          type="text"
          v-model="content.email"
          :errors="errors.email"
        />
        <TextInput
          id="subject"
          :label="$t('dashboard.subject')"
          type="text"
          v-model="content.subject"
          :errors="errors.subject"
        />
        <SelectComponent
          id="groups"
          :label="$t('dashboard.groups')"
          :value="content.groupId"
          :options="userGroups"
          :errors="errors.group"
          selection="Group"
          @selectGroup="handleSelectGroup"
        />
        <CheckBox
          :label="$t('dashboard.enableAutoresponse')"
          v-model="content.enableAutoresponse"
        />
        <div v-if="content.enableAutoresponse" class="space-y-2">
          <SelectComponent
            id="autoresponseEmailField"
            :label="$t('dashboard.autoresponseEmailField')"
            :value="content.autoresponseEmailFieldId"
            :options="possibleEmailFields"
            :errors="errors.autoresponseEmailField"
            selection="Field"
            @selectField="handleSelectField"
          />
          <TextInput
            id="autoresponseSubject"
            :label="$t('dashboard.autoresponseSubject')"
            type="text"
            v-model="content.autoresponseSubject"
            :errors="errors.autoresponseSubject"
          />
          <div>
            <FormLabel>
              {{ $t("dashboard.autoresponseMessage") }}
            </FormLabel>
            <Editor
              :label="$t('dashboard.autoresponseMessage')"
              v-model="content.autoresponseMessage"
              :errors="errors.autoresponseMessage"
            />
          </div>
        </div>
      </div>
    </Card>
    <div class="">
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
          :title="getTypeName(field.inputType)"
        >
          <div class="flex space-x-2">
            <TextInput
              id="label"
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
              id="label"
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
              id="label"
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
                :id="`selectFieldOption-${field.sort}-${i}`"
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
                  id="option"
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
import { nanoid } from "nanoid";
import Editor from "../../components/admin/Editor/Editor.vue";
import FormLabel from "../../components/admin/FormLabel.vue";
export default {
  components: {
    Card,
    TextInput,
    AddFormField,
    DragItemBox,
    ItemHeaderTemplate,
    CheckBox,
    SelectComponent,
    Editor,
    FormLabel,
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
      if (!field.optionFields) {
        field.optionFields = [];
      }
      field.optionFields.push({ name: event.target.value });
      event.target.value = "";
      await new Promise((resolve) => setTimeout(resolve, 10));
      const textFieldToFocus = document.getElementById(
        `selectFieldOption-${field.sort}-${field.optionFields.length - 1}`,
      );
      textFieldToFocus.childNodes[1].focus();
    },
    changeOrder(newField) {
      this.content.fields = this.content.fields.filter(
        (f) => f.id !== newField.id || f.tempId !== newField.tempId,
      );
      this.content.fields.push(newField);
      this.content.fields = this.content.fields.sort((a, b) => a.sort - b.sort);
      this.content.fields.forEach((f, i) => (f.sort = i));
    },
    addField(field) {
      field.tempId = nanoid();
      this.content.fields.push(field);
      this.content.fields = this.content.fields.sort((a, b) => a.sort - b.sort);
      this.content.fields.forEach((f, i) => (f.sort = i));
    },
    deleteField(item) {
      this.content.fields = this.content.fields.filter(
        (f) => f.sort !== item.sort,
      );
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
    handleSelectField(value) {
      this.content.autoresponseEmailFieldId = value;
    },
    getTypeName(inputType) {
      if (inputType === "text") {
        return this.$t("dashboard.textfield");
      } else if (inputType === "email") {
        return this.$t("dashboard.emailfield");
      } else if (inputType === "number") {
        return this.$t("dashboard.numberfield");
      } else if (inputType === "date") {
        return this.$t("dashboard.datefield");
      } else if (inputType === "time") {
        return this.$t("dashboard.timefield");
      } else {
        return inputType;
      }
    },
  },
  computed: {
    possibleEmailFields() {
      return this.content.fields
        .filter((f) => f.inputType === "email")
        .map((f) => ({
          id: f.id,
          name: f.label,
        }));
    },
  },
  async created() {
    await this.getForm();
  },
};
</script>

<style></style>
