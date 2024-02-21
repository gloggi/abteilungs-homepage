<template>
  <ContentWrapper>
    <HeadingOne class="w-full text-primary mb-2">{{
      item.faq.title
    }}</HeadingOne>
    <Question
      v-for="question in item.faq.questions"
      :question="question"
      :open="question.open"
    />
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingOne from "./HeadingOne.vue";
import Question from "./Question.vue";

export default {
  props: ["item"],
  components: { ContentWrapper, HeadingOne, Question },
};
</script>
