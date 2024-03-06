<template>
  <ContentWrapper>
    <HeadingTwo class="w-full text-primary mb-2">{{
      item.faq.title
    }}</HeadingTwo>
    <Question
      v-for="question in item.faq.questions"
      :question="question"
      :open="question.open === 1"
      :key="question.id"
    />
  </ContentWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import HeadingTwo from "./HeadingTwo.vue";
import Question from "./Question.vue";

export default {
  props: ["item"],
  components: { ContentWrapper, HeadingTwo, Question },
};
</script>
