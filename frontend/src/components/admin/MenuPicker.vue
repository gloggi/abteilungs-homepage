<template>
  <div class="flex space-x-2">
    <div class="flex flex-col space-y-2 w-1/2">
      <p class="text-2xl font-semibold break-words">
        {{ $t("dashboard.customLinks") }}
      </p>
      <div
        @dragenter.prevent=""
        @dragover.prevent
        @drop="handleDeleteDrop"
        class="border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <CustomMenuItem />
      </div>
      <p class="text-2xl font-semibold">{{ $t("dashboard.specialItems") }}</p>
      <div
        @dragenter.prevent=""
        @dragover.prevent
        @drop="handleDeleteDrop"
        class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <DragableMenuItem
          v-if="showGroupPagesItem"
          :item="{ special: 'groupPages' }"
        >
          {{ $t("dashboard.groupPagesDropdown") }}
        </DragableMenuItem>
      </div>
      <p class="text-2xl font-semibold">{{ $t("dashboard.pages") }}</p>
      <div
        @dragenter.prevent=""
        @dragover.prevent
        @drop="handleDeleteDrop"
        class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <DragableMenuItem v-for="page in pages" :item="page" :key="page.id">
          {{ page.title }}
        </DragableMenuItem>
      </div>
    </div>
    <div class="flex flex-col w-1/2 space-y-2">
      <p class="text-2xl font-semibold">{{ $t("dashboard.menu") }}</p>
      <div
        class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <MenuDropZone :index="-1" @dropped-item="handleMenuZoneDrop" />
        <template v-for="(menuItem, i) in menuItems" :key="menuItem.id">
          <DragableMenuItem :item="menuItem">
            {{ menuItem.title }}
          </DragableMenuItem>
          <MenuDropZone :index="i" @dropped-item="handleMenuZoneDrop" />
        </template>
      </div>
      <p class="text-2xl font-semibold break-words">
        {{ $t("dashboard.footerLinks") }}
      </p>
      <div
        class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <MenuDropZone :index="-1" @dropped-item="handleFooterLinksDrop" />
        <template v-for="(footerlink, i) in footerLinks" :key="footerlink.id">
          <DragableMenuItem :item="footerlink">
            {{ footerlink.title }}
          </DragableMenuItem>
          <MenuDropZone :index="i" @dropped-item="handleFooterLinksDrop" />
        </template>
      </div>
      <div
        v-if="menuItems.length > 0"
        :dropzone="true"
        @dragenter.prevent=""
        @dragover.prevent
        @drop="handleDeleteDrop"
        class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg"
      >
        <font-awesome-icon
          :icon="icons.faTrash"
          class="text-4xl text-gray-400"
        />
        <span class="text-gray-400 text-sm">{{
          $t("dashboard.removeItemFromMenu")
        }}</span>
      </div>
    </div>
  </div>
</template>
<script>
import CustomMenuItem from "./CustomMenuItem.vue";
import DragableMenuItem from "./DragableMenuItem.vue";
import MenuDropZone from "./MenuDropZone.vue";
import { faTrash } from "@fortawesome/free-solid-svg-icons";

export default {
  components: { DragableMenuItem, CustomMenuItem, MenuDropZone },
  data() {
    return {
      pages: [],
      menuItems: [],
      footerLinks: [],
      icons: {
        faTrash,
      },
    };
  },
  computed: {
    showGroupPagesItem() {
      return !this.menuItems.find((m) => m.special === "groupPages");
    },
  },
  methods: {
    async getPages() {
      try {
        const response = await this.callApi("get", "pages");
        this.pages = response.data.data;
        const pagesAlreadyInMenu = this.menuItems.filter(
          (menuItem) => menuItem.pageId,
        );
        this.pages = this.pages.filter(
          (page) =>
            !pagesAlreadyInMenu.find((menuItem) => menuItem.pageId === page.id),
        );
      } catch (error) {
        console.log(error);
      }
    },
    async getMenuItems() {
      try {
        const response = await this.callApi("get", "menuitems");
        this.menuItems = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async saveMenuItem(menuItem) {
      try {
        await this.callApi("post", "menuitems", menuItem);
        this.notifyUser(this.$t("dashboard.menuUpdated"));
      } catch (error) {
        console.log(error);
      }
    },
    async deleteMenuItem(menuItem) {
      try {
        await this.callApi("delete", `menuitems/${menuItem.id}`);
        this.notifyUser(this.$t("dashboard.menuItemDeleted"));
      } catch (error) {
        console.log(error);
      }
    },
    async getFooterLinks() {
      try {
        const response = await this.callApi("get", "footerlinks");
        this.footerLinks = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async saveFooterLink(link) {
      try {
        const response = await this.callApi("post", "footerlinks", link);
        this.footerLinks.push(response.data.data);
        this.notifyUser(this.$t("dashboard.footerLinkAdded"));
      } catch (error) {
        if (error.response.status === 422) {
          this.notifyUser(this.$t("dashboard.footerLinkError"));
        }
        console.log(error);
      }
    },
    async updateFooterLink(link) {
      try {
        await this.callApi("put", `footerlinks/${link.id}`, link);
      } catch (error) {
        console.log(error);
      }
    },
    async deleteFooterLink(link) {
      try {
        await this.callApi("delete", `footerlinks/${link.id}`);
      } catch (error) {
        console.log(error);
      }
    },
    async handleMenuZoneDrop(menuItem) {
      if (menuItem.type === "menuItem") {
        this.menuItems = this.menuItems.filter((mI) => mI.id !== menuItem.id);
      } else if (menuItem.special === "groupPages") {
        menuItem = {
          title: this.$t("dashboard.groupPagesDropdown"),
          sort: menuItem.sort,
          special: "groupPages",
        };
      } else {
        menuItem = {
          page_id: menuItem.id,
          title: menuItem.id ? undefined : menuItem.title,
          url: menuItem.url,
          sort: menuItem.sort,
        };
      }
      this.menuItems.push(menuItem);
      this.menuItems = this.menuItems.sort((a, b) => a.sort - b.sort);
      var i = 0;
      for (let mI of this.menuItems) {
        mI.sort = i;
        await this.saveMenuItem(mI);
        i++;
      }
      await this.getMenuItems();
      await this.getPages();
    },
    async handleFooterLinksDrop(footerLink) {
      const isCustomItem = footerLink.type === "customItem" && !footerLink.id;
      const isFooterLink =
        footerLink.type === "footerLink" &&
        footerLink.url &&
        footerLink.title &&
        footerLink.id;

      if (isCustomItem || isFooterLink) {
        if (isCustomItem) {
          this.footerLinks.push(footerLink);
        } else {
          this.footerLinks = this.footerLinks.filter(
            (link) => link.id !== footerLink.id,
          );
          this.footerLinks.push(footerLink);
        }

        this.updateFooterLinksOrder();
        await this.saveAllFooterLinks();
        await this.getFooterLinks();
      }
    },

    updateFooterLinksOrder() {
      this.footerLinks.sort((a, b) => a.sort - b.sort);
      this.footerLinks = this.footerLinks.map((link, index) => ({
        ...link,
        sort: index,
      }));
    },

    async saveAllFooterLinks() {
      await Promise.all(
        this.footerLinks.map(async (link) =>
          link.id
            ? await this.updateFooterLink(link)
            : await this.saveFooterLink(link),
        ),
      );
    },
    async handleDeleteDrop(e) {
      const item = JSON.parse(e.dataTransfer.getData("text/plain"));
      if (item.type === "menuItem") {
        await this.deleteMenuItem(item);
        await this.getMenuItems();
        await this.getPages();
      } else if (item.type === "footerLink") {
        await this.deleteFooterLink(item);
        await this.getFooterLinks();
      }
    },
  },
  async created() {
    await this.getMenuItems();
    await this.getPages();
    await this.getFooterLinks();
  },
};
</script>
