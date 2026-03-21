<template>
  <TransitionGroup
    tag="div"
    enter-active-class="transform ease-out duration-300 transition"
    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
    leave-active-class="transition ease-in duration-100"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
    move-class="transition ease-in-out duration-500"
    class="fixed z-100 flex flex-col gap-2 w-full max-w-sm right-0 bottom-0 p-4 pointer-events-none"
  >
    <div
      v-for="notification in notifications"
      :key="notification.id"
      class="pointer-events-auto relative flex w-full items-start justify-between space-x-4 overflow-hidden rounded-md border p-6 shadow-lg transition-all"
      :class="variantClasses(notification.variant)"
    >
      <div class="flex gap-3 w-full">
        <font-awesome-icon
          :icon="getIcon(notification.variant)"
          class="h-5 w-5 mt-0.5 shrink-0"
          :class="iconClasses(notification.variant)"
        />
        <div class="flex flex-col gap-1 flex-1">
          <div class="text-sm font-semibold leading-none tracking-tight">
            {{ notification.title }}
          </div>
          <div
            v-if="notification.description"
            class="text-sm opacity-90 leading-snug"
          >
            {{ notification.description }}
          </div>
        </div>
      </div>
      <button
        @click="dismiss(notification.id)"
        class="absolute right-2 top-2 rounded-md p-1 transition-colors focus:outline-hidden focus:ring-2 focus:ring-gray-400 group-hover:opacity-100"
        :class="closeButtonClasses(notification.variant)"
      >
        <font-awesome-icon :icon="icons.faXmark" class="h-4 w-4" />
      </button>
    </div>
  </TransitionGroup>
</template>

<script>
import {
  faCircleCheck,
  faCircleXmark,
  faInfoCircle,
  faXmark,
} from "@fortawesome/free-solid-svg-icons";

export default {
  name: "Toast",
  data() {
    return {
      icons: {
        faCircleCheck,
        faCircleXmark,
        faInfoCircle,
        faXmark,
      },
    };
  },
  computed: {
    notifications() {
      return this.$store.state.notification.notifications;
    },
  },
  methods: {
    dismiss(id) {
      this.$store.commit("notification/remove", id);
    },
    variantClasses(variant) {
      switch (variant) {
        case "destructive":
          return "bg-white border-red-200 text-red-900 shadow-xs";
        case "success":
          return "bg-white border-green-200 text-green-900 shadow-xs";
        default:
          return "bg-white border-gray-200 text-gray-900 shadow-xs";
      }
    },
    iconClasses(variant) {
      switch (variant) {
        case "destructive":
          return "text-red-600";
        case "success":
          return "text-green-600";
        default:
          return "text-gray-600";
      }
    },
    closeButtonClasses() {
      return "text-gray-500 hover:text-gray-900";
    },
    getIcon(variant) {
      switch (variant) {
        case "destructive":
          return this.icons.faCircleXmark;
        case "success":
          return this.icons.faCircleCheck;
        default:
          return this.icons.faInfoCircle;
      }
    },
  },
};
</script>
