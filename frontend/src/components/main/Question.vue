<template>
  <div>
    <div class="border border-primary bg-primary mb-2 rounded-lg">
      <button
        @click="show = !show"
        class="text-left w-full bg-primary p-5 flex flex-col text-white rounded-lg"
      >
        <HeadingThree>{{ question.question }}</HeadingThree>
      </button>
      <Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
        <div v-if="show" class="h-full bg-white rounded-b-lg">
          <div class="p-3">
            <div v-html="question.answer" v-router-link></div>
          </div>
        </div>
      </Transition>
    </div>
  </div>
</template>
<script>
import { gsap } from "gsap";
import HeadingThree from "./HeadingThree.vue";

export default {
  components: {
    HeadingThree,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    question: {
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
