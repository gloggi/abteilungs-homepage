<template>
  <router-view />
</template>
<script>
export default {
  methods: {
    setupStyles() {
      this.createNewCssVariable("--primary-color", this.settings.primaryColor);
      this.createNewCssVariable(
        "--secondary-color",
        this.settings.secondaryColor,
      );
      this.createNewCssClass(
        "bg-primary",
        `background-color: ${this.settings.primaryColor};`,
      );
      this.createNewCssClass(
        "text-primary",
        `color: ${this.settings.primaryColor};`,
      );
      this.createNewCssClass(
        "hover\\:text-primary:hover",
        `color: ${this.settings.primaryColor};`,
      );
      this.createNewCssClass(
        "border-primary",
        `border-color: ${this.settings.primaryColor};`,
      );
      this.createNewCssClass(
        "bg-secondary",
        `background-color: ${this.settings.secondaryColor};`,
      );
      this.createNewCssClass(
        "text-secondary",
        `color: ${this.settings.secondaryColor};`,
      );
      this.createNewCssClass(
        "hover\\:text-secondary:hover",
        `color: ${this.settings.secondaryColor};`,
      );
      this.createNewCssClass(
        "border-primary",
        `border-color: ${this.settings.primaryColor};`,
      );
      this.createNewCssClass(
        "border-secondary",
        `border-color: ${this.settings.secondaryColor};`,
      );
      this.createNewCssClass(
        "focus\\:border-secondary:focus",
        `border-color: ${this.settings.secondaryColor};`,
      );
    },
  },
  computed: {},
  async created() {
    await this.$store.dispatch("user/getUser");
    await this.$store.dispatch("settings/getSettings");
    this.setupStyles();
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600,300italic,600italic");

.main-text {
  color: #333333;
  font-family:
    "Source Sans Pro",
    "system-ui",
    -apple-system,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Fira Sans",
    "Droid Sans",
    "Helvetica Neue",
    Helvetica,
    Arial,
    sans-serif;
  font-size: 24px;
  line-height: 36px;
}
@media screen and (max-width: 700px) {
  .main-text {
    font-size: 18px;
    line-height: 30px;
  }
}

.text-heading-1 {
  font-family:
    "Source Sans Pro",
    "system-ui",
    -apple-system,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Fira Sans",
    "Droid Sans",
    "Helvetica Neue",
    Helvetica,
    Arial,
    sans-serif;
  font-weight: 600;
  text-shadow: 0px 0px 10px black;
}

.text-heading-2 {
  font-family:
    "Source Sans Pro",
    "system-ui",
    -apple-system,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Fira Sans",
    "Droid Sans",
    "Helvetica Neue",
    Helvetica,
    Arial,
    sans-serif;
  font-weight: 300;
}

.text-heading-3 {
  font-family:
    "Source Sans Pro",
    "system-ui",
    -apple-system,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Fira Sans",
    "Droid Sans",
    "Helvetica Neue",
    Helvetica,
    Arial,
    sans-serif;
  font-weight: 300;
}

.link {
  color: #337ab7;
}
</style>
