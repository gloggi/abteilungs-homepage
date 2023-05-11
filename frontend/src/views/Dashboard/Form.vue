<template>
  <div v-if="content">
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ content.name }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: 'Forms' }">
        <button class="rounded-l-lg bg-white p-1">
          <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6 text-gray-500" />
        </button>
      </router-link>
      <div>
        <button @click="deletePage" class="bg-white p-1 border-r border-l border-gray-200">
          <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1" @click="updateForm">
          <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
    <Card class="mt-4">

      <div class="space-y-2 w-full">
        <TextInput label="Name" type="text" v-model="content.name" />
        <TextInput label="E-Mail" type="text" v-model="content.email" />
        <TextInput label="Subject" type="text" v-model="content.subject" />
        <h2 class="font-semibold text-2xl">Form Fields</h2>
        <AddFormField />
        <template v-for="field in content.fields" :key="field.id">
          <FormItemBox v-if="field.type == 'textField'" :title="field.input_type || field.type">
              <TextInput type="text" v-model="field.label" label="Label" />
          </FormItemBox>
          <ItemBox v-if="field.type == 'textareaField'" :title="field.type">
            <TextInput type="text" v-model="field.label" label="Label" />
          </ItemBox>
          <ItemBox v-if="field.type == 'selectField'" :title="field.type">
            <TextInput type="text" v-model="field.label" label="Label" />
            <ItemBox class="space-y-2 pl-5 mt-3" title="Options" :key="field.option_fields.length">
              <div v-for="(option, i) in field.option_fields" :key="option.id">
                <TextInput type="text" v-model="option.name" :label="`Option ${i + 1}`" />
              </div>
              <div>
                <button @click="addOption(field.id + field.label)"
                  class="p-3 rounded-lg border flex justify-center items-center w-full hover:bg-gray-200"><font-awesome-icon
                    :icon="icons.faPlus" class="h-5 w-5" /></button>
              </div>
            </ItemBox>
          </ItemBox>
          <AddFormField />
        </template>
      </div>
    </Card>
  </div>
</template>
  
<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus, faGripVertical } from "@fortawesome/free-solid-svg-icons";
import AddFormField from "../../components/admin/AddFormField.vue";
import ItemBox from "../../components/admin/ItemBox.vue";
import FormItemBox from "../../components/admin/FormItemBox.vue";

export default {
  components: {
    Card,
    TextInput,
    AddFormField,
    ItemBox,
    FormItemBox
},
  data() {
    return {
      content: undefined,
      sections: undefined,
      showModal: false,
      forms: [],
      icons: {
        faArrowsRotate,
        faChevronLeft,
        faTrash,
        faPlus,
        faGripVertical
      }
    };
  },
  methods: {
    updateLogo(id) {
      this.content.file_id = id;
      this.updateForm()

    },
    addOption(fieldIdAndLabel) {
      const field = this.content.fields.find(f => f.id + f.label == fieldIdAndLabel)
      console.log(field)
      field.option_fields.push({ name: "" })
    },
    async getForm() {
      try {
        const response = await this.callApi(
          "get",
          `/forms/${this.$route.params.id}`
        );
        this.content = response.data;
        if (this.content.predecessors) {
          this.content.predecessors = this.content.predecessors.map(p => p.id)
        }
        if (this.content.successors) {
          this.content.successors = this.content.successors.map(p => p.id)
        }
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async getForms() {
      try {
        const response = await this.callApi(
          "get",
          `/forms`
        );
        this.forms = response.data.data;
      } catch (e) {
        console.log(e);
      }
    },
    async getSections() {
      try {
        const response = await this.callApi(
          "get",
          `/sections`
        );
        this.sections = response.data.data;
        console.log(this.sections)
      } catch (e) {
        console.log(e);
      }
    },
    async updateForm() {
      try {
        await this.callApi(
          "put",
          `/forms/${this.$route.params.id}`,
          this.content
        );
      } catch (e) {
        console.log(e);
      }
    },
    handleSection(sectionId) {
      this.content.sectionId = sectionId
    }
  },
  async created() {
    await this.getSections();
    await this.getForms();
    await this.getForm();

  },
};
</script>
  
<style></style>