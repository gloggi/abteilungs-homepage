<template>
  <div class="justify-center flex flex-col bg-gray-900 items-center h-screen">
    <div class="w-full px-5 sm:w-1/2 md:w-1/4">
      <div class="bg-white rounded-lg p-4 shadow-lg flex space-y-4 flex-col">
        <form
          v-if="false"
          class="flex space-y-4 flex-col"
          @submit.prevent="login"
        >
          <div class="text-4xl font-bold">Login</div>
          <ErrorMessage />
          <hr />

          <TextInput
            v-model="form.email"
            label="E-Mail"
            type="text"
            :content="form.email"
          ></TextInput>
          <TextInput
            v-model="form.password"
            label="Password"
            type="password"
            :content="form.email"
          ></TextInput>
          <ButtonComponent type="submit">Login</ButtonComponent>
        </form>
        <MiDataButton @click="loginWithMiData" type="submit" />
      </div>
    </div>
    <SuccessMessage />
  </div>
</template>
<script>
import TextInput from "../components/admin/TextInput.vue";
import ButtonComponent from "../components/admin/ButtonComponent.vue";
import ErrorMessage from "../components/admin/ErrorMessage.vue";
import MiDataButton from "../components/admin/MiDataButton.vue";
import SuccessMessage from "../components/admin/SuccessNotification.vue";
export default {
  name: "Login",
  components: {
    SuccessMessage,
    TextInput,
    ButtonComponent,
    ErrorMessage,
    MiDataButton,
  },
  data() {
    return {
      form: {
        email: undefined,
        password: undefined,
      },
    };
  },
  watch: {
    isAdmin() {
      if (this.isAdmin) {
        this.$router.push("/dashboard");
      }
    },
    isUnitLeader() {
      if (this.isUnitLeader) {
        this.$router.push("/dashboard");
      }
    },
  },
  methods: {
    async login() {
      try {
        await this.callApi("post", "/auth/login", this.form);
        await this.$store.dispatch("user/getUser");
        this.$router.push("/dashboard");
      } catch (e) {
        console.log(e);
      }
    },
    async loginWithMiData() {
      try {
        const response = await this.callApi("get", "/auth/midata");
        const url = response.data.url;
        window.location.href = url;
      } catch (e) {
        console.log(e);
      }
    },
    async handleOAuthCode() {
      const code = this.$route.query.code;
      if (!code) {
        return;
      }
      const response = await this.callApi("post", "/auth/midata/callback", {
        code,
      });
      localStorage.setItem("token", response.data.token);
      await this.$store.dispatch("user/getUser");
      this.$router.push("/dashboard");
    },
  },
  created() {
    if (this.isUnitLeader || this.isAdmin) {
      this.$router.push("/dashboard");
    }
    this.handleOAuthCode();
  },
};
</script>
