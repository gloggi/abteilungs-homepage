<template>
  <div
    v-if="show"
    class="fixed bottom-0 md:bottom-10 md:left-10 z-20 bg-white p-5 w-full md:w-1/3 drop-shadow-2xl rounded-lg"
  >
    <h4 class="font-bold text-xl text-primary">Datenschutz</h4>
    <p class="main-text text-sm">
      Unsere Website verwendet Cookies und ähnliche Technologien, um User zu
      authentifizieren und Landkarten von swisstopo anzuzeigen. Durch die
      weitere Nutzung dieser Website stimmst du der Verwendung dieser
      Technologien zu.
    </p>
    <a
      href="https://pfadi.swiss/de/verband/datenschutz/dse/"
      class="link hover:text-secondary underline text-sm"
      >Datenschutzerklärung der Pfadibewegung Schweiz</a
    >
    <div class="flex pt-3 w-full">
      <BasicButton @click="acceptCookies" class="text-sm w-full">
        Okay
      </BasicButton>
    </div>
  </div>
</template>
<script>
import BasicButton from "./BasicButton.vue";

export default {
  data() {
    return {
      show: false,
    };
  },
  methods: {
    acceptCookies() {
      localStorage.setItem("cookieBanner", "accepted");
      this.show = false;
    },
  },
  components: { BasicButton },
  created() {
    if (!localStorage.getItem("cookieBanner")) {
      this.show = true;
    }
  },
};
</script>
