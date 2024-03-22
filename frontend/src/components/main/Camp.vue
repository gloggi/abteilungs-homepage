<template>
  <div>
    <div class="border border-primary mb-2 rounded-lg">
      <button
        @click="show = !show"
        class="text-left w-full bg-primary p-5 flex flex-col text-white rounded-lg"
      >
        <HeadingTwo>{{ camp.name }}</HeadingTwo>
        <div class="w-full">
          <p class="main-text text-white text-xl">
            <span class="font-semibold">{{ $t("page.campDateLabel") }}: </span>
            {{ getDate(camp) }}
          </p>
          <p
            v-if="camp.applicationClosingAt"
            class="main-text text-white text-xl"
          >
            <span class="font-semibold"
              >{{ $t("page.applicationClosingLabel") }}:
            </span>
            {{ formatDate(camp.applicationClosingAt) }}
          </p>
        </div>
      </button>
      <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
        <div v-if="show" class="h-full">
          <div class="p-3">
            <p v-if="camp.applicationOpeningAt" class="main-text text-xl">
              <span class="font-semibold"
                >{{ $t("page.applicationOpeningLabel") }}:
              </span>
              {{ formatDate(camp.applicationOpeningAt) }}
            </p>
            <p v-if="camp.cost" class="main-text text-xl">
              <span class="font-semibold">{{ $t("page.costLabel") }}: </span>CHF
              {{ camp.cost }}
            </p>
            <div
              v-if="camp.customDescription"
              v-html="camp.customDescription"
              v-router-link
            ></div>
            <p v-else-if="camp.description" class="main-text text-xl">
              {{ camp.description }}
            </p>
            <div class="flex justify-end w-full">
              <BasicButton class="self-end" v-if="camp.externalApplicationLink">
                <a :href="camp.externalApplicationLink">
                  {{ $t("page.applyOnMiData") }}
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
import HeadingTwo from "./HeadingTwo.vue";
import { format } from "date-fns";
import { de } from "date-fns/locale";
import { gsap } from "gsap";
import BasicButton from "./BasicButton.vue";

export default {
  components: {
    HeadingTwo,
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
  methods: {
    formatDate(date) {
      return format(new Date(date), "dd. MMMM yyyy", { locale: de });
    },
    formatTime(date) {
      return format(new Date(date), "HH:mm");
    },
    isSameDay(date1, date2) {
      return (
        format(new Date(date1), "dd.MM.yyyy", { locale: de }) ===
        format(new Date(date2), "dd.MM.yyyy", { locale: de })
      );
    },
    getDate(camp) {
      if (this.isSameDay(camp.startAt, camp.finishAt)) {
        return this.formatDate(camp.startAt);
      }
      if (
        format(new Date(camp.startAt), "yyyy", { locale: de }) ===
        format(new Date(camp.finishAt), "yyyy", { locale: de })
      ) {
        return `${format(new Date(camp.startAt), "dd.", {
          locale: de,
        })} - ${format(new Date(camp.finishAt), "dd. MMMM yyyy", {
          locale: de,
        })}`;
      }
      return `${format(new Date(camp.startAt), "dd. MMMM yyyy", {
        locale: de,
      })} - ${format(new Date(camp.finishAt), "dd. MMMM yyyy", {
        locale: de,
      })}`;
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
