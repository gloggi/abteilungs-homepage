<template>
  <div v-if="hasChildren" class="relative group-dropdown-container">
    <li
      @click="toggleDropdown"
      class="flex flex-row space-x-2 items-center font-light p-3 py-5 md:py-0 md:p-0 hover:text-secondary main-text md:text-2xl cursor-pointer"
      :style="{ color: settings?.navbarFontColor }"
    >
      <div>{{ menuItem.title }}</div>
      <font-awesome-icon :icon="icons.faCaretDown" :class="{'rotate-180': showDropdown}" class="transition-transform duration-200" />
    </li>
    <div class="md:absolute z-10 right-0 w-full md:w-max min-w-[200px]">
      <transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
        <ul v-if="showDropdown" class="bg-primary w-full h-full rounded-b-lg shadow-lg md:mt-2 overflow-hidden flex flex-col">
          <NavBarItem
             v-for="child in menuItem.children"
             :key="child.id"
             :menuItem="child"
             :is-child="true"
             @item-clicked="closeDropdown"
          />
        </ul>
      </transition>
    </div>
  </div>
  <li
    v-else
    class="font-light p-3 py-5 md:p-0 hover:text-secondary main-text md:text-2xl"
    :class="{'pl-8 md:px-5 md:py-2 w-full hover:bg-black/10': isChild}"
    :style="{ color: settings?.navbarFontColor }"
  >
    <router-link
      v-if="menuItem.url && menuItem.url.startsWith('/')"
      :to="menuItem.url"
      @click="handleClick"
      class="block w-full"
    >
      {{ menuItem.title }}
    </router-link>
    <a v-else :href="menuItem.url" class="block w-full" @click="handleClick">{{ menuItem.title }}</a>
  </li>
</template>

<script>
import { faCaretDown } from "@fortawesome/free-solid-svg-icons";
import { gsap } from "gsap";

export default {
  name: "NavBarItem",
  props: {
    menuItem: {
      type: Object,
      required: true,
    },
    isChild: {
        type: Boolean,
        default: false
    }
  },
  emits: ["item-clicked"],
  data() {
    return {
      showDropdown: false,
      icons: {
        faCaretDown,
      },
    };
  },
  computed: {
    hasChildren() {
        return this.menuItem.children && this.menuItem.children.length > 0;
    }
  },
  methods: {
    toggleDropdown() {
        this.showDropdown = !this.showDropdown;
    },
    closeDropdown() {
        this.showDropdown = false;
        this.$emit('item-clicked');
    },
    handleClick() {
        this.$emit('item-clicked');
    },
    beforeEnter(el) {
      el.style.height = "0";
      el.style.overflow = "hidden";
      el.style.opacity = "0";
    },
    enter(el, done) {
      gsap.to(el, { height: "auto", opacity: 1, duration: 0.3, onComplete: done });
    },
    leave(el, done) {
      gsap.to(el, { height: "0", opacity: 0, duration: 0.3, onComplete: done });
    },
  },
};
</script>
