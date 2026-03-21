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
      this.createNewCssVariable(
        "--side-bg-color",
        this.settings.sideBgColor || "#808080",
      );
      this.createNewCssClass(
        "bg-side",
        `background-color: ${this.settings.sideBgColor || "#808080"};`,
      );
      this.createNewCssVariable(
        "--main-font-size",
        `${this.settings.fontSize || 36}px`,
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

/* Table styles for content rendered on the main page */
table {
  border-collapse: collapse;
  margin: 1rem 0;
  overflow: hidden;
  table-layout: fixed;
  width: 100%;
}

table td,
table th {
  border: 1px solid var(--primary-color);
  box-sizing: border-box;
  min-width: 1em;
  padding: 0.5rem 0.75rem;
  position: relative;
  vertical-align: top;
}

table td > *,
table th > * {
  margin-bottom: 0;
}

table th {
  font-weight: 600;
  text-align: left;
}

table tr:first-child th {
  border-top: 2px solid var(--primary-color);
}

table tr th:first-child {
  border-left: 2px solid var(--primary-color);
}

table tr:last-child td,
table tr:last-child th {
  border-bottom: 2px solid var(--primary-color);
}

table tr td:last-child,
table tr th:last-child {
  border-right: 2px solid var(--primary-color);
}
</style>
