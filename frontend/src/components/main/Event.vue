<template>
  <div>
    <ContentWrapper>
      <div class="border border-primary mb-2 rounded-lg">
        <button
          @click="show = !show"
          class="text-left w-full bg-primary p-5 flex flex-col text-white rounded-lg"
        >
          <HeadingTwo>{{ event.title }}</HeadingTwo>
          <div class="w-full flex flex-wrap">
            <p class="main-text text-white text-base md:text-xl w-1/2">
              <span class="font-semibold">{{ $t("page.dateLabel") }}:</span>
              {{ getDate(event) }}
            </p>
            <p class="main-text text-white text-base md:text-xl w-1/2">
              <span class="font-semibold">{{ $t("page.timeLabel") }}:</span>
              {{ formatTime(event.startTime) }} -
              {{ formatTime(event.endTime) }}
            </p>
            <p
              v-if="
                (event.startLocation && !event.endLocation) ||
                event.startLocation?.name === event.endLocation?.name
              "
              class="main-text text-white text-base md:text-xl w-full md:w-1/2"
            >
              <span class="font-semibold">{{ $t("page.locationLabel") }}:</span>
              {{ event.startLocation?.name }}
            </p>
            <template v-else>
              <p class="main-text text-white text-base md:text-xl w-1/2">
                <span class="font-semibold"
                  >{{ $t("page.startLocationLabel") }}:</span
                >
                {{ event.startLocation?.name }}
              </p>
              <p class="main-text text-white text-base md:text-xl w-1/2">
                <span class="font-semibold"
                  >{{ $t("page.endLocationLabel") }}:</span
                >
                {{ event.endLocation?.name }}
              </p>
            </template>

            <p
              v-if="event.groups.length > 1"
              class="main-text text-white text-base md:text-xl w-full md:w-1/2"
            >
              <span class="font-semibold">{{ $t("page.groupsLabel") }}:</span>
              {{ event.groups.map((g) => g.name).join(", ") }}
            </p>
          </div>
        </button>
        <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
          <div v-if="show" class="h-full">
            <MapComponent
              class="w-full h-96"
              :markers="[event.startLocation, event.endLocation]"
            />
            <div class="p-3">
              <div v-html="event.description" v-router-link></div>
              <p class="main-text" v-if="event.user">
                {{ $t("page.contactMessage") }}
                <a
                  class="link hover:text-secondary"
                  :href="`mailto:${event.user.email}`"
                  >{{
                    event.user.nickname
                      ? event.user.nickname
                      : event.user.firstname
                  }}</a
                >.
              </p>

              <h4
                v-if="event.takeWithYou"
                class="font-bold text-3xl text-primary pt-2"
              >
                {{ $t("page.takeWithYouLabel") }}
              </h4>
              <div
                v-if="event.takeWithYou"
                v-html="event.takeWithYou"
                v-router-link
              ></div>
              <h4
                v-if="event.files.length > 0"
                class="font-bold text-3xl text-primary pt-2"
              >
                {{ $t("page.downloadsLabel") }}
              </h4>
              <FilesItem v-if="event.files.length > 0" :files="event.files" />
              <div class="flex justify-end w-full">
                <BasicButton
                  class="self-end"
                  v-if="event.externalApplicationLink"
                >
                  <a :href="event.externalApplicationLink">
                    {{ $t("page.applyOnMiData") }}
                  </a>
                </BasicButton>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </ContentWrapper>
  </div>
</template>
<script>
import HeadingTwo from "./HeadingTwo.vue";
import MapComponent from "./MapComponent.vue";
import { format } from "date-fns";
import { de } from "date-fns/locale";
import { gsap } from "gsap";
import ContentWrapper from "./ContentWrapper.vue";
import FilesItem from "./FilesItem.vue";
import BasicButton from "./BasicButton.vue";

export default {
  components: {
    HeadingTwo,
    MapComponent,
    ContentWrapper,
    FilesItem,
    BasicButton,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    event: {
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
        format(new Date(date1), "dd.MM.yyyy") ===
        format(new Date(date2), "dd.MM.yyyy")
      );
    },
    getDate(event) {
      if (this.isSameDay(event.startTime, event.endTime)) {
        return this.formatDate(event.startTime);
      }
      if (
        format(new Date(event.startTime), "yyyy") ===
        format(new Date(event.endTime), "yyyy")
      ) {
        return `${format(new Date(event.startTime), "dd.MM.")} - ${format(
          new Date(event.endTime),
          "dd.MM.yyyy",
        )}`;
      }
      return `${format(new Date(event.startTime), "dd. MM yyyy")} - ${format(
        new Date(event.endTime),
        "dd. MM yyyy",
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
