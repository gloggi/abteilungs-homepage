<template>
  <PageWrapper v-if="group">
    <TextItem :item="{ title: group.name, body: group.description }" />
    <FilesItem
      v-if="group.files.length > 0"
      :title="$t('page.downloads')"
      :files="group.files"
    />
    <div>
      <ContentWrapper>
        <HeadingOne class="text-primary pb-5">{{
          $t("page.events")
        }}</HeadingOne>
      </ContentWrapper>
      <div v-if="events.length > 0">
        <Event
          v-for="(event, idx) in events"
          :open="idx === 0"
          :key="event.id"
          :event="event"
        />
        <EventPager
          @changePage="changeEventPage"
          :numberOfPages="eventLastPage"
          :currentPage="eventPage"
        />
      </div>
      <ContentWrapper v-else>
        <p class="main-text">{{ $t("page.noEventsAvailable") }}</p>
      </ContentWrapper>
    </div>
  </PageWrapper>
</template>
<script>
import ContentWrapper from "./ContentWrapper.vue";
import Event from "./Event.vue";
import EventPager from "./EventPager.vue";
import FilesItem from "./FilesItem.vue";
import HeadingOne from "./HeadingOne.vue";
import PageWrapper from "./PageWrapper.vue";
import TextItem from "./TextItem.vue";

export default {
  props: ["group"],
  data() {
    return {
      events: [],
      eventPage: 1,
      eventLastPage: 1,
    };
  },
  methods: {
    async getEvents() {
      try {
        const response = await this.callApi(
          "get",
          "/events",
          {},
          {
            params: {
              group_id: this.group.id,
              page: this.eventPage,
              per_page: 3,
            },
          },
        );
        this.events = response.data.data;
        this.eventLastPage = response.data.lastPage;
      } catch (error) {
        console.log(error);
      }
    },
    changeEventPage(page) {
      this.eventPage = page;
      this.getEvents();
    },
  },
  async created() {
    this.getEvents();
  },
  components: {
    PageWrapper,
    TextItem,
    Event,
    HeadingOne,
    FilesItem,
    ContentWrapper,
    EventPager,
  },
};
</script>
