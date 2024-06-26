<template>
  <div>
    <ItemHeaderTemplate
      :title="content.title"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="faqs"
      backLinkTo="Faqs"
    />
    <Card class="mt-4">
      <TextInput
        id="title"
        :label="$t('dashboard.title')"
        type="text"
        v-model="content.title"
        :errors="errors.title"
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
    </Card>
    <AddQuestion
      @changeOrder="changeOrder"
      @select="addField"
      :dragging="isDragging"
      :sortKey="-1"
    />
    <template v-for="question in content.questions" :key="question.id">
      <DragItemBox
        :item="question"
        @delete="deleteField"
        @startedDragging="isDragging = true"
        @endedDragging="isDragging = false"
        :title="$t('dashboard.question')"
      >
        <div>
          <div class="w-full flex space-x-2">
            <TextInput
              id="question"
              class="w-full"
              type="text"
              v-model="question.question"
              :label="$t('dashboard.question')"
            />
            <CheckBox
              class="text-nowrap"
              :label="$t('dashboard.defaultOpen')"
              v-model="question.open"
            />
          </div>
          <Editor v-model="question.answer" />
        </div>
      </DragItemBox>
      <AddQuestion
        @changeOrder="changeOrder"
        @select="addField"
        :dragging="isDragging"
        :sortKey="question.sort"
      />
    </template>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import {
  faArrowsRotate,
  faChevronLeft,
  faTrash,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";
import Editor from "../../components/admin/Editor/Editor.vue";
import AddQuestion from "../../components/admin/AddQuestion.vue";
import DragItemBox from "../../components/admin/DragItemBox.vue";
import CheckBox from "../../components/admin/CheckBox.vue";
import SelectComponent from "../../components/admin/SelectComponent.vue";
import { nanoid } from "nanoid";
export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
    Editor,
    AddQuestion,
    DragItemBox,
    CheckBox,
    SelectComponent,
  },
  data() {
    return {
      content: {
        questions: [],
      },
      isDragging: false,
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
  methods: {
    async getFaq() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/faqs/${this.$route.params.id}`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async updateFaq() {
      this.sortQuestions();

      try {
        await this.callApi(
          "put",
          `/faqs/${this.$route.params.id}`,
          this.content,
        );
        this.$t("dashboard.itemUpdatedMessage");
      } catch (e) {
        console.log(e);
      }
    },
    handleErrors(errors) {
      this.errors = errors;
    },
    addField(field) {
      field.tempId = nanoid();
      this.content.questions.push(field);
      this.sortQuestions();
    },
    deleteField(field) {
      this.content.questions = this.content.questions.filter(
        (f) => f.tempId !== field.tempId || f.id !== field.id,
      );
    },
    changeOrder(newField) {
      this.content.questions = this.content.questions.filter(
        (f) => f.tempId !== newField.tempId || f.id !== newField.id,
      );
      this.content.questions.push(newField);
      this.sortQuestions();
    },
    sortQuestions() {
      this.content.questions = this.content.questions.sort(
        (a, b) => a.sort - b.sort,
      );
      this.content.questions.forEach((q, i) => {
        q.sort = i;
      });
    },
    handleSelectGroup(value) {
      this.content.groupId = value;
    },
  },
  async created() {
    await this.$store.dispatch("groups/fetchGroups");
    await this.getFaq();
  },
};
</script>

<style></style>
