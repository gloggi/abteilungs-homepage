<template>
  <div class="w-full">
    <FormLabel :for="id">
      {{ label }}
    </FormLabel>
    <div class="relative" @mouseleave="showDropdown = false">
      <select
        :id="id"
        @mousedown.prevent
        @click="handleClickSelect"
        class="flex h-10 w-full items-center justify-between rounded-md border border-gray-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-950 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1"
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
      <div v-if="errors" class="text-red-500 text-xs">
        {{ errors.join(" ") }}
      </div>
      <div
        v-if="showDropdown"
        class="absolute top-11 z-50 min-w-[8rem] w-full overflow-hidden rounded-md border border-gray-200 bg-white text-gray-950 shadow-md animate-in fade-in-80"
      >
        <div
          v-for="option in options"
          :key="option.id"
          class="relative flex w-full cursor-default select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none focus:bg-gray-100 focus:text-gray-900 data-[disabled]:pointer-events-none data-[disabled]:opacity-50 hover:bg-gray-100"
        >
          <input
            :checked="this.payload.includes(option.id)"
            @change="(event) => select(event, option.id)"
            class="mr-2 h-4 w-4 shrink-0 rounded-sm border border-gray-200 border-gray-900 text-gray-900 focus:ring-1 focus:ring-gray-950 disabled:cursor-not-allowed disabled:opacity-50"
            type="checkbox"
          />
          <div>{{ option.name }}</div>
        </div>
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
    errors: {
      type: Array,
      default: () => [],
    },
    id: {
      type: String,
      default: "",
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
