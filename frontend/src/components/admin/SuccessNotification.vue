<template>
  <TransitionRoot
    appear
    :show="$store.state.notification.show"
    as="template"
    enter="transform transition duration-1000"
    enter-from="opacity-0 translate -translate-y-full scale-50"
    enter-to="opacity-100  scale-100  -translate-y-0"
    leave="transform duration-200 transition ease-in-out"
    leave-from="opacity-100 scale-100 "
    leave-to="opacity-0 scale-95"
  >
    <div
      class="absolute z-100 p-2 bottom-5 right-5 rounded-lg shadow-lg text-white flex justify-between"
      :class="`${
        $store.state.notification.error ? 'bg-red-400' : 'bg-green-400'
      }`"
    >
      <font-awesome-icon
        v-if="$store.state.notification.error"
        :icon="icons.faCircleXmark"
        class="w-6 h-6"
      />
      <font-awesome-icon v-else :icon="icons.faCircleCheck" class="w-6 h-6" />
      <div class="text font-semibold ml-1">
        {{ $store.state.notification.message }}
      </div>
    </div>
  </TransitionRoot>
</template>

<script>
import {
  faCircleCheck,
  faCircleXmark,
} from "@fortawesome/free-solid-svg-icons";
import { TransitionRoot } from "@headlessui/vue";
export default {
  components: { TransitionRoot },
  data() {
    return {
      icons: {
        faCircleCheck,
        faCircleXmark,
      },
    };
  },
};
</script>

<style></style>
