<template>
  <div>
    <ItemHeaderTemplate
      :title="content.name"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="tags"
      backLinkTo="Tags"
      :modelName="$t('dashboard.tag')"
    />
    <Card class="mt-4">
      <div class="space-y-4">
        <TextInput
          id="name"
          :label="$t('dashboard.name')"
          type="text"
          v-model="content.name"
          :errors="errors.name"
        />
      </div>
    </Card>
  </div>
</template>

<script>
import Card from "../../components/admin/Card.vue";
import TextInput from "../../components/admin/TextInput.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";

export default {
  components: {
    Card,
    TextInput,
    ItemHeaderTemplate,
  },
  data() {
    return {
      content: {},
      loadedKey: 0,
      errors: {},
    };
  },
  methods: {
    async getTag() {
      if (this.$route.params.id === "new") {
        return;
      }
      try {
        const response = await this.callApi(
          "get",
          `/tags/${this.$route.params.id}`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    handleErrors(errors) {
      this.errors = errors;
    },
  },
  async created() {
    await this.getTag();
  },
};
</script>
