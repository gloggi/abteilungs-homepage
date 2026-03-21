<template>
  <div class="w-full">
    <FormLabel :label-for="id" v-if="label">
      {{ label }}
    </FormLabel>
    <div class="relative">
      <input
        :value="value"
        class="flex h-10 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 pr-10 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-gray-500"
        :id="id"
        readonly
        @click="highlightValue"
      />
      <div class="absolute right-0 top-0 h-full flex items-center pr-1">
        <ButtonComponent
          variant="ghost"
          size="icon"
          class="h-8 w-8 text-gray-500 hover:text-gray-900"
          @click="copyToClipboard"
          :title="copied ? 'Copied!' : 'Copy to clipboard'"
        >
          <font-awesome-icon :icon="copied ? icons.check : icons.copy" />
        </ButtonComponent>
      </div>
    </div>
  </div>
</template>

<script>
import ButtonComponent from "./ButtonComponent.vue";
import FormLabel from "./FormLabel.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faCopy, faCheck } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { ButtonComponent, FormLabel, FontAwesomeIcon },
  props: ["label", "value", "id"],
  data() {
    return {
      copied: false,
      icons: {
        copy: faCopy,
        check: faCheck,
      },
    };
  },
  methods: {
    highlightValue(event) {
      event.target.select();
    },
    async copyToClipboard() {
      if (!this.value) return;
      try {
        await navigator.clipboard.writeText(this.value);
        this.copied = true;
        setTimeout(() => {
          this.copied = false;
        }, 2000);
      } catch (err) {
        console.error("Failed to copy:", err);
      }
    },
  },
};
</script>
