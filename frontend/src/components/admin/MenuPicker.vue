<template>
  <div>
    <ItemHeaderTemplate
      :title="$t('dashboard.menuStructure')"
      backLinkTo="DashboardHome"
      :noDelete="true"
      :noUpdate="true"
    >
      <template #buttons-after>
        <ActionButton
          @click="saveAll"
          :toolTipText="$t('dashboard.saveChanges')"
        >
          <font-awesome-icon
            :icon="icons.faArrowsRotate"
            class="h-6 w-6"
          />
        </ActionButton>
      </template>
    </ItemHeaderTemplate>

    <div class="flex flex-col-reverse md:flex-row gap-6">
      <div class="w-full md:w-1/3 flex flex-col gap-4">
        <NavAvailableItems
          :pages="availablePages"
          :usedSpecials="usedSpecials"
        />
      </div>

      <div class="w-full md:w-2/3 flex flex-col gap-8">
        <NavEditor
          :items="menuItems"
          @update:items="updateItems"
        />

        <div class="border-t pt-8">
          <h3 class="text-lg font-bold text-gray-800 mb-4">
            {{ $t("dashboard.footerLinks") }}
          </h3>
          <NavEditor
            :items="footerLinks"
            @update:items="updateFooterLinks"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavAvailableItems from "./NavAvailableItems.vue";
import NavEditor from "./NavEditor.vue";
import ItemHeaderTemplate from "./ItemHeaderTemplate.vue";
import ActionButton from "./ActionButton.vue";
import { faArrowsRotate } from "@fortawesome/free-solid-svg-icons";

export default {
  name: "MenuPicker",
  components: { 
      NavAvailableItems, 
      NavEditor, 
      ItemHeaderTemplate,
      ActionButton
  },
  data() {
    return {
      pages: [],
      menuItems: [],
      footerLinks: [],
      isSaving: false,
      icons: {
          faArrowsRotate
      }
    };
  },
  computed: {
    availablePages() {
      
      const usedPageIds = new Set();
      const traverse = (items) => {
        items.forEach(item => {
          const pId = item.page_id || item.pageId;
          if (pId) usedPageIds.add(String(pId));
          if (item.children) traverse(item.children);
        });
      };
      traverse(this.menuItems);
      
      traverse(this.footerLinks);
      
      return this.pages.filter(p => !usedPageIds.has(String(p.id)));
    },
    usedSpecials() {
       const specials = new Set();
       const traverse = (items) => {
           items.forEach(item => {
               if (item.special) specials.add(item.special);
               if (item.children) traverse(item.children);
           });
       };
       traverse(this.menuItems);
       return Array.from(specials);
    }
  },
  async created() {
    await this.loadData();
  },
  methods: {
    async loadData() {
        try {
            const [menuRes, pagesRes, footerRes] = await Promise.all([
                this.callApi("get", "menuitems"),
                this.callApi("get", "pages"),
                this.callApi("get", "footerlinks")
            ]);
            
            this.menuItems = menuRes.data.data;
            this.pages = pagesRes.data.data;
            this.footerLinks = footerRes.data.data;
        } catch (error) {
            console.error("Failed to load data", error);
        }
    },
    
    updateItems(newItems) {
        this.menuItems = newItems;
    },
    
    updateFooterLinks(newItems) {
        this.footerLinks = newItems;
    },

    async saveAll() {
        this.isSaving = true;
        try {
             
             
             const currentMenuRes = await this.callApi("get", "menuitems");
             const currentMenuIds = currentMenuRes.data.data.map(i => flatten(i)).flat();
             
             function flatten(i) { return [i.id, ...(i.children ? i.children.map(c => flatten(c)).flat() : [])]; }
             
             const frontendMenuIds = new Set();
             const collectIds = (items) => {
                 items.forEach(i => {
                     if (i.id) frontendMenuIds.add(i.id);
                     if (i.children) collectIds(i.children);
                 });
             };
             collectIds(this.menuItems);
             
             const menuToDelete = currentMenuIds.filter(id => !frontendMenuIds.has(id));
             await Promise.all(menuToDelete.map(id => this.callApi("delete", `menuitems/${id}`)));
             
             
             await this.processSaveQueue(this.menuItems, null, 'menuitems');


             
             
             
             const currentFooterRes = await this.callApi("get", "footerlinks");
             const currentFooterIds = currentFooterRes.data.data.map(i => i.id);
             
             const frontendFooterIds = new Set(this.footerLinks.map(i => i.id).filter(id => id));
             const footerToDelete = currentFooterIds.filter(id => !frontendFooterIds.has(id));
             
             await Promise.all(footerToDelete.map(id => this.callApi("delete", `footerlinks/${id}`)));
             
             
             
             
             
             
             for (let i = 0; i < this.footerLinks.length; i++) {
                 const link = this.footerLinks[i];
                 link.sort = i;
                 
                 
                 if (link.id) {
                     await this.callApi("put", `footerlinks/${link.id}`, link);
                 } else {
                     const res = await this.callApi("post", "footerlinks", link);
                     link.id = res.data.id; 
                 }
             }
             
             await this.loadData();
             this.notifyUser(this.$t("dashboard.menuUpdated"));
             
        } catch (error) {
            console.error(error);
            this.notifyUser("Error saving menu");
        } finally {
            this.isSaving = false;
        }
    },
    
    async processSaveQueue(items, parentId, endpoint) {
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            item.sort = i;
            item.parent_id = parentId;
            
            
            const payload = { ...item };
            delete payload.children; 
            delete payload.tempId; 
            if (!payload.id) delete payload.id; 

            
            
            
            
            
            
            
            const res = await this.callApi("post", endpoint, payload);
            
            if (!item.id && res.data.id) {
                item.id = res.data.id;
            }
            
            if (items[i].children && items[i].children.length > 0) {
                await this.processSaveQueue(items[i].children, item.id, endpoint);
            }
        }
    }
 } 
};
</script>

