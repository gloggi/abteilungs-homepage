<template>
  <ContentWrapper>
    <div class="w-full">
      <div
        v-for="section in sections"
        class="flex flex-col md:flex-row p-3"
        :key="section.id"
        :style="`background-color: ${section.color}`"
      >
        <div
          class="flex flex-row md:flex-col space-x-3 md:space-x-0 md:justify-between items-start md:items-center md:space-y-12 mb-3 md:mb-0"
        >
          <img
            v-if="section.file"
            :src="this.backendURL + '/' + section.file?.path"
            class="size-[60px] md:size-[100px]"
          />
          <div v-else class="size-[60px] md:size-[100px]"></div>
          <div>
            <h3 class="text-2xl md:text-3xl text-heading-3 text-primary">
              {{ section.name }}
            </h3>
            <p class="main-text text-base md:text-lg text-white">
              {{ section.fromAge }} - {{ section.toAge }} Jahre
            </p>
          </div>
        </div>
        <div class="flex flex-wrap justify-around w-full items-center">
          <template v-for="group in groups" :key="group.id">
            <div
              v-if="group.section.id === section.id && !group.parentId"
              @click="selectGroup(group)"
              class="relative cursor-pointer rounded-full aspect-square w-[100px] md:w-[150px] flex justify-center items-center"
              :style="`background-color: ${group.color}`"
            >
              <div
                class="absolute top-0 right-0 rounded-full size-6 md:size-10 bg-secondary flex justify-center items-center"
              >
                <img
                  :src="selectGenderIcon(group.gender)"
                  class="w-[65%] h-[65%]"
                />
              </div>
              <img
                v-if="group.file?.path"
                :src="this.backendURL + '/' + group.file?.path"
                class="w-[60%] h-[60%]"
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
    <div class="w-full mx-5 md:mx-0 md:w-1/2 h-full bg-white flex flex-col">
      <div class="bg-primary px-3 py-5 flex justify-between items-end">
        <h2 class="text-white text-heading-3 text-6xl">
          {{ currentGroup.name }}
        </h2>
        <div
          class="relative rounded-full aspect-square w-[100px] flex justify-center items-center"
          :style="`background-color: ${currentGroup.color}`"
        >
          <img
            :src="this.backendURL + '/' + currentGroup.file?.path"
            class="w-[60%] h-[60%]"
          />
        </div>
      </div>
      <div class="p-8 h-full flex flex-col justify-between">
        <div class="border border-primary w-full p-3">
          <p class="main-text text-lg">
            <span class="font-semibold">Alter:</span>
            {{ currentGroup.section.fromAge }} -
            {{ currentGroup.section.toAge }} Jahre
          </p>
          <p class="main-text text-lg">
            <span class="font-semibold">Geschlecht:</span>
            {{ getGenderName(currentGroup.gender) }}
          </p>
          <template v-if="currentGroup.predecessors.length > 0">
            <p>
              <span class="font-semibold">{{
                currentGroup.predecessors.lenght > 1
                  ? "Vorgängergruppen"
                  : "Vorgängergruppe"
              }}</span>
            </p>
            <ul class="list-disc pl-6">
              <li v-for="p in currentGroup.predecessors" :key="p.id">
                {{ p.name }}
              </li>
            </ul>
          </template>
          <template v-if="currentGroup.successors.length > 0">
            <p>
              <span class="font-semibold">{{
                currentGroup.successors.lenght > 1
                  ? "Nachfolgergruppen"
                  : "Nachfolgergruppe"
              }}</span>
            </p>
            <ul class="list-disc pl-6">
              <li v-for="s in currentGroup.successors" :key="s.id">
                {{ s.name }}
              </li>
            </ul>
          </template>
          <p class="main-text text-lg">
            <span class="font-semibold">Kontakt: </span>
            <a class="link" :href="`mailto:${currentGroup.contact}`"
              >Gruppenleitung</a
            >
          </p>
        </div>
        <BasicButton>
          <router-link :to="`/group/${currentGroup.id}`" class="w-full"
            >Zur Gruppenseite</router-link
          >
        </BasicButton>
      </div>
    </div>
  </div>
</template>
<script>
import BasicButton from "./BasicButton.vue";
import ContentWrapper from "./ContentWrapper.vue";

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
      this.currentGroup = group;
      history.pushState({}, null, `${this.$route.path}#${group.id}`);
    },
    checkHash() {
      if (this.$route.hash) {
        const id = this.$route.hash.split("#")[1];
        this.currentGroup = this.groups.find((g) => g.id === parseInt(id));
      }
    },
  },
  async created() {
    this.getSections();
    this.getGroups();
    this.checkHash();
  },
  components: { ContentWrapper, BasicButton },
};
</script>
