<template>
  <div class="absolute" style="top: 8%; right: 8%;">
    <Listbox>
      <div class="flex flex-col items-end">
        <ListboxButton
          ><div class="rounded-full bg-white p-1 border border-gray-200">
            <PencilIcon class="h-5 w-5 text-gray-500" /></div
        ></ListboxButton>
        <ListboxOptions class="rounded-lg bg-white p-1">
          <ListboxOption
            class="
              bg-white
              rounded-lg
              hover:bg-gray-200
              cursor-pointer
              p-2
              text-sm text-gray-500
            "
            @click="$emit(option.name.toLowerCase())"
            v-for="option in options"
            :key="option"
            :value="option"
          >
            {{ option.name }}
          </ListboxOption>
        </ListboxOptions>
      </div>
    </Listbox>
  </div>
</template>


<script>
import { PencilIcon } from "@heroicons/vue/24/solid";

import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
export default {
  components: {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    PencilIcon,
  },
  data() {
    return {
      options: [
        { id: 1, name: "Replace" },
        { id: 2, name: "Remove" },
      ],
    };
  },
  created(){
    
  }
};
</script>