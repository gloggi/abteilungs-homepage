<template>
  <div>
    <div class="border border-primary mb-2">
      <button
        @click="show = !show"
        class="text-left w-full bg-primary p-5 flex flex-col text-white"
      >
        <HeadingOne>{{ camp.name }}</HeadingOne>
        <div class="w-full">
          <p class="main-text text-white text-xl">
            <span class="font-semibold">Lagerdatum: </span>
            {{ getDate(camp) }}
          </p>
          <p
            v-if="camp.applicationClosingAt"
            class="main-text text-white text-xl"
          >
            <span class="font-semibold">Anmeldeschluss: </span>
            {{ formatDate(camp.applicationClosingAt) }}
          </p>
        </div>
      </button>
      <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
        <div v-if="show" class="h-full">
          <div class="p-3">
            <p v-if="camp.applicationOpeningAt" class="main-text text-xl">
              <span class="font-semibold">Anmeldebeginn: </span>
              {{ formatDate(camp.applicationOpeningAt) }}
            </p>
            <p v-if="camp.cost" class="main-text text-xl">
              <span class="font-semibold">Kosten: </span>CHF
              {{ camp.cost }}
            </p>
            <div
              v-if="camp.description && isHTML"
              v-html="camp.description"
              v-router-link
            ></div>
            <p v-else class="main-text text-xl">
              {{ camp.description }}
            </p>
            <div class="flex justify-end w-full">
              <BasicButton class="self-end" v-if="camp.externalApplicationLink">
                <a :href="camp.externalApplicationLink">
                  Auf MiData anmelden
                </a>
              </BasicButton>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </div>
</template>
<script>
import HeadingOne from "./HeadingOne.vue";
import { format } from "date-fns";
import { de } from "date-fns/locale";
import { gsap } from "gsap";
import BasicButton from "./BasicButton.vue";

export default {
  components: {
    HeadingOne,
    BasicButton,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    camp: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      show: false,
    };
  },
  computed: {
    isHTML() {
      return this.camp.description.substring(0, 1) === "<";
    },
  },
  methods: {
    formatDate(date) {
      return format(new Date(date), "dd. MMMM yyyy", { locale: de });
    },
    formatTime(date) {
      return format(new Date(date), "HH:mm");
    },
    isSameDay(date1, date2) {
      return (
        format(new Date(date1), "dd.MM.yyyy") ===
        format(new Date(date2), "dd.MM.yyyy")
      );
    },
    getDate(camp) {
      if (this.isSameDay(camp.startAt, camp.finishAt)) {
        return this.formatDate(camp.startAt);
      }
      if (
        format(new Date(camp.startAt), "yyyy") ===
        format(new Date(camp.finishAt), "yyyy")
      ) {
        return `${format(new Date(camp.startAt), "dd.")} - ${format(
          new Date(camp.finishAt),
          "dd. MMMM yyyy",
        )}`;
      }
      return `${format(new Date(camp.startAt), "dd. MMMM yyyy")} - ${format(
        new Date(camp.finishAt),
        "dd. MMMM yyyy",
      )}`;
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
    this.show = this.open;
  },
};
</script>
