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
  <div class="absolute z-100 p-2 bottom-5 right-5 rounded-lg bg-green-400 shadow-lg text-white flex justify-between">
      <CheckCircleIcon />
      <div class="text font-semibold ml-1">{{$store.state.notification.message}}</div>
  </div>
</TransitionRoot>

</template>

<script>
import CheckCircleIcon from '../../icons/CheckCircleIcon.vue'
import { TransitionRoot } from '@headlessui/vue'
export default {
  components: { CheckCircleIcon, TransitionRoot },

}
</script>

<style>

</style>