<template>
  <div>
    <ItemHeaderTemplate
      :title="content.subject"
      :content="content"
      @errors="handleErrors"
      @clearErrors="errors = {}"
      entity="events"
      backLinkTo="Events"
      noDelete="true"
      noUpdate="true"
    >
      <template v-slot:buttons-before>
        <ActionButton
          @click="sendMail"
          :toolTipText="$t('dashboard.sendEmail')"
        >
          <font-awesome-icon :icon="icons.faPaperPlane" class="h-6 w-6" />
        </ActionButton>
      </template>
    </ItemHeaderTemplate>

    <Card class="mt-4">
      <div class="flex flex-col space-y-2">
        <TextInput
          id="subject"
          :label="$t('dashboard.subject')"
          type="text"
          v-model="content.subject"
        />
        <TextInput
          id="from"
          :label="$t('dashboard.from')"
          type="text"
          v-model="content.from"
        />
        <Textarea
          id="receiver"
          :label="$t('dashboard.to')"
          v-model="content.receiver"
        />
        <Editor
          :label="$t('dashboard.emailContent')"
          id="emailContent"
          v-model="content.content"
        />
      </div>
    </Card>
  </div>
</template>
<script>
import Card from "../../components/admin/Card.vue";
import ItemHeaderTemplate from "../../components/admin/ItemHeaderTemplate.vue";
import ActionButton from "../../components/admin/ActionButton.vue";
import { faPaperPlane } from "@fortawesome/free-solid-svg-icons";
import Textarea from "../../components/admin/Textarea.vue";
import TextInput from "../../components/admin/TextInput.vue";
import Editor from "../../components/admin/Editor/Editor.vue";
export default {
  components: {
    Card,
    ItemHeaderTemplate,
    ActionButton,
    Textarea,
    TextInput,
    Editor,
  },
  data() {
    return {
      content: {
        subject: undefined,
        from: undefined,
        receiver: undefined,
        content: undefined,
        bbc: undefined,
      },
      errors: {},
      icons: {
        faPaperPlane,
      },
    };
  },
  methods: {
    async getEvent() {
      try {
        const response = await this.callApi(
          "get",
          `/events/${this.$route.params.id}/mail`,
        );
        this.content = response.data;
        this.loadedKey++;
      } catch (e) {
        console.log(e);
      }
    },
    async sendMail() {
      try {
        await this.callApi("post", `/events/${this.$route.params.id}/mail`, {
          ...this.content,
        });
        this.notifyUser(this.$t("dashboard.emailSent"));
        this.$router.push({ name: "Events" });
      } catch (e) {
        this.notifyUser(e.response.data.message, "error");
      }
    },
    handleErrors(errors) {
      this.errors = errors;
    },
  },
  created() {
    this.getEvent();
  },
};
</script>
