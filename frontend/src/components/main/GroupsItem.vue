<template>
  <ContentWrapper>
    <div class="w-full">
      <div
        v-for="(section, i) in sections"
        class="flex flex-col md:flex-row p-3"
        :key="section.id"
        :style="`background-color: ${section.color}`"
        :class="
          i === 0
            ? 'rounded-t-lg'
            : i === sections.length - 1
              ? 'rounded-b-lg'
              : ''
        "
      >
        <div
          class="flex flex-row md:flex-col space-x-3 md:space-x-0 md:justify-between items-start md:items-center md:space-y-12 mb-3 md:mb-0"
        >
          <img
            v-if="section.file"
            :src="backendURL + section.file?.path"
            class="size-[60px] md:size-[100px]"
          />
          <div v-else class="size-[60px] md:size-[100px]"></div>
          <div>
            <h3 class="text-2xl md:text-3xl text-heading-3 text-primary">
              {{ section.name }}
            </h3>
            <p class="main-text text-lg md:text-lg text-white">
              {{ section.fromAge }} - {{ section.toAge }} Jahre
            </p>
          </div>
        </div>
        <div class="flex flex-wrap justify-around w-full items-center gap-y-2">
          <template v-for="(group, i) in section.groups" :key="group.id">
            <GroupCircle
              v-if="
                !group.parentId &&
                !(
                  section.groups.length > 3 &&
                  section.groups.length % 3 == 1 &&
                  i > section.groups.length - 3
                )
              "
              :group="group"
              :gender-icon="selectGenderIcon(group.gender)"
              @select-group="selectGroup"
            />
            <div
              class="flex justify-around w-full"
              v-if="
                section.groups.length > 3 &&
                section.groups.length % 3 == 1 &&
                i > section.groups.length - 3 &&
                i == section.groups.length - 1
              "
            >
              <GroupCircle
                :group="section.groups[i - 1]"
                :gender-icon="selectGenderIcon(section.groups[i - 1].gender)"
                @select-group="selectGroup"
              />
              <GroupCircle
                :group="section.groups[i]"
                :gender-icon="selectGenderIcon(section.groups[i].gender)"
                @select-group="selectGroup"
              />
            </div>
          </template>
        </div>
      </div>
    </div>
  </ContentWrapper>
  <div
    v-if="currentGroup"
    @click.self="selectGroup(undefined)"
    class="fixed inset-0 z-30 bg-black bg-opacity-80 h-screen w-screen flex justify-center items-center py-10"
    style="margin-top: 0"
  >
    <div
      class="w-full mx-5 md:mx-0 md:w-1/2 h-full bg-white flex flex-col rounded-lg"
    >
      <div
        class="bg-primary px-3 py-5 flex justify-between items-end rounded-t-lg"
      >
        <h2 class="text-white text-heading-3 text-6xl">
          {{ currentGroup.name }}
        </h2>
        <div
          class="relative rounded-full aspect-square w-[100px] flex justify-center items-center"
          :style="`background-color: ${currentGroup.color}`"
        >
          <img
            :src="backendURL + currentGroup.file?.path"
            class="w-[60%] h-[60%]"
          />
        </div>
      </div>
      <div class="p-8 h-full flex flex-col justify-between">
        <div class="border border-primary w-full p-3 rounded-lg">
          <p class="main-text text-lg">
            <span class="font-semibold">{{ $t("page.ageLabel") }}:</span>
            {{ currentGroup.section.fromAge }} -
            {{ currentGroup.section.toAge }} Jahre
          </p>
          <p class="main-text text-lg">
            <span class="font-semibold">{{ $t("page.genderLabel") }}:</span>
            {{ getGenderName(currentGroup.gender) }}
          </p>
          <p class="main-text text-lg">
            <span class="font-semibold">{{ $t("page.region") }}:</span>
            {{ currentGroup.region }}
          </p>
          <template v-if="currentGroupChildren.length > 0">
            <p class="main-text text-lg">
              <span class="font-semibold">{{
                $t("page.groupChildren")
              }}</span>
            </p>
            <ul class="list-disc pl-6 main-text text-lg">
              <li v-for="c in currentGroupChildren" :key="c.id">
                {{ c.name }}
              </li>
            </ul>
          </template>
          <template v-if="currentGroup.predecessors.length > 0">
            <p class="main-text text-lg">
              <span class="font-semibold">{{
                currentGroup.predecessors.length > 1
                  ? $t("page.predecessorGroups")
                  : $t("page.predecessorGroup")
              }}</span>
            </p>
            <ul class="list-disc pl-6 main-text text-lg">
              <li v-for="p in currentGroup.predecessors" :key="p.id">
                {{ p.name }}
              </li>
            </ul>
          </template>
          <template v-if="currentGroup.successors.length > 0">
            <p>
              <span class="font-semibold">{{
                currentGroup.successors.length > 1
                  ? $t("page.successorGroups")
                  : $t("page.successorGroup")
              }}</span>
            </p>
            <ul class="list-disc pl-6 main-text text-lg">
              <li v-for="s in currentGroup.successors" :key="s.id">
                {{ s.name }}
              </li>
            </ul>
          </template>
          <p class="main-text text-lg">
            <span class="font-semibold">{{ $t("page.contactLabel") }}: </span>
            <a class="link" :href="`mailto:${currentGroup.contact}`">{{
              $t("page.groupLeadership")
            }}</a>
          </p>
        </div>
        <BasicButton
          v-if="currentGroup.hasPage"
          @click="goToGroupPage(currentGroup.route)"
        >
          {{ $t("page.goToGroupPage") }}
        </BasicButton>
      </div>
    </div>
  </div>
</template>
<script>
import BasicButton from "./BasicButton.vue";
import ContentWrapper from "./ContentWrapper.vue";
import GroupCircle from "./GroupCircle.vue";

export default {
  props: ["item"],
  data() {
    return {
      currentGroup: undefined,
    };
  },
  computed: {
    groups() {
      return this.$store.state.groups.groups;
    },
    sections() {
      return this.$store.state.sections.sections;
    },
    currentGroupChildren(){
      return this.groups.filter((g) => g.parent?.id === this.currentGroup.id);

    }
  },
  methods: {
    getSections() {
      this.$store.dispatch("sections/fetchSections");
    },
    getGroups() {
      this.$store.dispatch("groups/fetchGroups");
    },
    selectGenderIcon(gender) {
      if (gender === 1) {
        return this.getAsset("b.svg");
      } else if (gender === 2) {
        return this.getAsset("m.svg");
      } else if (gender === 3) {
        return this.getAsset("f.svg");
      }
    },
    getGenderName(gender) {
      if (gender === 1) {
        return "Gemischte Gruppe";
      } else if (gender === 2) {
        return "Jungs";
      } else if (gender === 3) {
        return "Mädchen";
      }
    },
    selectGroup(group) {
      if (!group) {
        this.currentGroup = undefined;
        history.pushState({}, null, this.$route.path);
        return;
      }
      this.currentGroup = this.groups.find((g) => g.id === group.id);
      history.pushState({}, null, `${this.$route.path}#${group.id}`);
    },
    checkHash() {
      if (this.$route.hash) {
        const id = this.$route.hash.split("#")[1];
        this.currentGroup = this.groups.find((g) => g.id === parseInt(id));
      }
    },
    goToGroupPage(route) {
      this.$router.push(`/group/${route}`);
    },
  },
  async created() {
    this.getSections();
    this.getGroups();
    this.checkHash();
  },
  components: { ContentWrapper, BasicButton, GroupCircle },
};
</script>
