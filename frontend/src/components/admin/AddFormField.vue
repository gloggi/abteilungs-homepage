<template>
  <AddItemButton
    :items="fields"
    :dragging="dragging"
    :sortKey="sortKey"
    :dragText="$t('dashboard.dropFormItemHere')"
    :addText="$t('dashboard.clickToAddFormItem')"
    :modalTitle="$t('dashboard.formFields')"
    @select="$emit('select', $event)"
    @changeOrder="$emit('changeOrder', $event)"
  />
</template>

<script>
import { markRaw } from "vue";
import AddItemButton from "./AddItemButton.vue";
import Textfield from "../../assets/FormFields/Textfield.svg?component";
import Numberfield from "../../assets/FormFields/Numberfield.svg?component";
import Datefield from "../../assets/FormFields/Datefield.svg?component";
import Timefield from "../../assets/FormFields/Timefield.svg?component";
import Emailfield from "../../assets/FormFields/Emailfield.svg?component";
import Textareafield from "../../assets/FormFields/Textareafield.svg?component";
import Selectfield from "../../assets/FormFields/Selectfield.svg?component";

export default {
  components: {
    AddItemButton,
  },
  props: ["sortKey", "dragging"],
  emits: ["select", "changeOrder"],
  data() {
    return {
      fields: [
        {
          name: this.$t("dashboard.textfield"),
          type: "textField",
          inputType: "text",
          component: markRaw(Textfield),
        },
        {
          name: this.$t("dashboard.numberfield"),
          type: "textField",
          inputType: "number",
          component: markRaw(Numberfield),
        },
        {
          name: this.$t("dashboard.datefield"),
          type: "textField",
          inputType: "date",
          component: markRaw(Datefield),
        },
        {
          name: this.$t("dashboard.timefield"),
          type: "textField",
          inputType: "time",
          component: markRaw(Timefield),
        },
        {
          name: this.$t("dashboard.email"),
          type: "textField",
          inputType: "email",
          component: markRaw(Emailfield),
        },
        {
          name: this.$t("dashboard.textareafield"),
          type: "textareaField",
          component: markRaw(Textareafield),
        },
        {
          name: this.$t("dashboard.selectfield"),
          type: "selectField",
          component: markRaw(Selectfield),
        },
      ],
    };
  },
};
</script>

