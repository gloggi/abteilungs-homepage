<template>
  <DragItemBox
    :boxTitle="boxTitle"
    :item="item"
    @delete="(event) => $emit('delete', event)"
    @startedDragging="$emit('startedDragging')"
    @endedDragging="$emit('endedDragging')"
  >
    <Card class="space-y-2">
      <div class="">
        <div class="flex flex-col md:flex-row space-x-2">
          <TextInput
            class="w-full"
            :label="$t('dashboard.title')"
            v-model.lazy="titleValue"
          />
          <CheckBox
            class="text-nowrap"
            :label="$t('dashboard.showFleurDeLis')"
            v-model="fleurDeLisValue"
          />
        </div>
        <Editor v-model="bodyValue" />
      </div>
    </Card>
  </DragItemBox>
</template>

<script>
import Card from "../Card.vue";
import CheckBox from "../CheckBox.vue";
import DragItemBox from "../DragItemBox.vue";
import Editor from "../Editor/Editor.vue";
import FormLabel from "../FormLabel.vue";
import TextInput from "../TextInput.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
export default {
  components: { TextInput, Editor, Card, DragItemBox, FormLabel, CheckBox },
  props: ["title", "body", "item", "boxTitle", "fleurDeLis"],
  emits: [
    "updatePage",
    "update:title",
    "update:body",
    "update:fleurDeLis",
    "delete",
    "startedDragging",
    "endedDragging",
  ],
  data() {
    return {
      textItem: undefined,
      icons: {
        faTrash,
      },
    };
  },
  methods: {
    change() {},
  },
  computed: {
    titleValue: {
      get() {
        return this.title;
      },
      set(value) {
        this.$emit("update:title", value);
      },
    },
    bodyValue: {
      get() {
        return this.body;
      },
      set(value) {
        this.$emit("update:body", value);
      },
    },
    fleurDeLisValue: {
      get() {
        return this.fleurDeLis;
      },
      set(value) {
        this.$emit("update:fleurDeLis", value);
      },
    },
  },
  created() {},
};
</script>

<style></style>
