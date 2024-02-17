<template>
  <FormLabel>
    {{ label }}
  </FormLabel>
  <div class="relative" @mouseleave="showDropdown = false">
    <select
      @mousedown.prevent
      @click="handleClickSelect"
      class="appearance-none border relative rounded w-full py-2 px-3 text-gray-700 leading-tight border-gray-500 focus:outline-none focus:shadow-outline"
    >
      <option selected :key="displayKey">
        {{
          payload.length > 0
            ? options
                .filter((o) => payload.includes(o.id))
                .map((o) => o.name)
                .join(", ")
            : "-"
        }}
      </option>
    </select>
    <div v-if="showDropdown" class="absolute bg-white z-30 rounded-lg w-full">
      <div
        v-for="option in options"
        :key="option.id"
        class="p-2 m-1 hover:bg-gray-50 rounded-lg flex flex-row space-x-2 items-center"
      >
        <input
          :checked="this.payload.includes(option.id)"
          @change="(event) => select(event, option.id)"
          class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900"
          type="checkbox"
        />
        <div>{{ option.name }}</div>
      </div>
    </div>
  </div>
</template>
<script>
import FormLabel from "./FormLabel.vue";

export default {
  components: { FormLabel },
  emits: ["update:modelValue"],
  props: {
    label: {
      type: String,
    },
    modelValue: {},
    options: {
      default: [],
    },
  },
  data() {
    return {
      showDropdown: false,
      displayKey: 0,
    };
  },
  methods: {
    handleClickSelect() {
      this.showDropdown = !this.showDropdown;
    },
    select(event, objectid) {
      if (event.target.checked) {
        this.payload.push(objectid);
      } else {
        this.payload = this.payload.filter((i) => i !== objectid);
      }
      this.displayKey++;
    },
  },
  computed: {
    payload: {
      get() {
        return this.modelValue || [];
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
};
</script>
