<template>
  <div class="relative">
    <li
      @click="showDropdown = !showDropdown"
      class="min-w-[130px] flex flex-row space-x-2 items-center font-light p-3 py-5 md:py-0 md:p-0 hover:text-secondary text-white main-text md:text-2xl cursor-pointer"
    >
      <div>{{ $t("page.groups") }}</div>
      <font-awesome-icon class="" :icon="icons.faCaretDown" />
    </li>
    <transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
      <ul
        v-if="showDropdown"
        class="absolute z-10 bg-primary w-full h-full rounded-lg"
      >
        <template v-for="group in groups" :key="group.id">
          <li
            v-if="group.hasPage"
            class="font-light p-3 py-5 pl-8 md:py-2 md:p-3 w-full md:px-5 hover:text-secondary text-white main-text md:text-2xl"
          >
            <router-link
              @click="showDropdown = false"
              :to="`/group/${group.route}`"
              >{{ group.name }}</router-link
            >
          </li>
        </template>
      </ul>
    </transition>
  </div>
</template>

<script>
import { faCaretDown } from "@fortawesome/free-solid-svg-icons";
import { gsap } from "gsap";
export default {
  data() {
    return {
      showDropdown: false,
      icons: {
        faCaretDown,
      },
    };
  },
  computed: {
    groups() {
      return this.$store.state.groups.groups;
    },
  },
  methods: {
    getGroups() {
      this.$store.dispatch("groups/fetchGroups");
    },
    beforeEnter(el) {
      el.style.height = "0";
      el.style.overflow = "hidden";
    },
    enter(el, done) {
      gsap.to(el, { height: "auto", duration: 0.3, onComplete: done });
    },
    leave(el, done) {
      gsap.to(el, { height: "0", duration: 0.3, onComplete: done });
    },
  },
  created() {
    this.getGroups();
  },
};
</script>
