<template>
    <div class="flex space-x-2">
        <div class="flex flex-col space-y-2 w-1/2">
            <p class="text-2xl font-semibold">Custom Links</p>
            <div @dragenter.prevent="" @dragover.prevent @drop="handleDeleteDrop"
                class="border-2 border-gray-400 border-dashed text-center p-5 rounded-lg">
                <CustomMenuItem />
            </div>
            <p class="text-2xl font-semibold">Special Items</p>
            <div @dragenter.prevent="" @dragover.prevent @drop="handleDeleteDrop"
                class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg">
                <DragableMenuItem v-if="showGroupPagesItem" :item="{special: 'groupPages'}" >
                   Group Pages Dropdown
                </DragableMenuItem>
            </div>
            <p class="text-2xl font-semibold">Pages</p>
            <div @dragenter.prevent="" @dragover.prevent @drop="handleDeleteDrop"
                class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg">
                <DragableMenuItem v-for="page in pages" :item="page" :key="page.id">
                    {{ page.title }}
                </DragableMenuItem>
            </div>
        </div>
        <div class="flex flex-col w-1/2 space-y-2">
            <p class="text-2xl font-semibold">Menu</p>
            <div class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg">
                <MenuDropZone :index="-1" @dropped-item="handleMenuZoneDrop" />
                <template v-for="(menuItem, i) in menuItems" :key="menuItem.id">
                    <DragableMenuItem :item="menuItem">
                        {{ menuItem.title }}
                    </DragableMenuItem>
                    <MenuDropZone :index="i" @dropped-item="handleMenuZoneDrop" />
                </template>
            </div>
            <div v-if="menuItems.length>0" :dropzone="true" @dragenter.prevent="" @dragover.prevent @drop="handleDeleteDrop" class="flex flex-col space-y-2 border-2 border-gray-400 border-dashed text-center p-5 rounded-lg">
                <font-awesome-icon :icon="icons.faTrash" class="text-4xl text-gray-400" />
                <span class="text-gray-400 text-sm">Remove item from menu.</span>
                </div>
        </div>
    </div>
</template>
<script>
import CustomMenuItem from './CustomMenuItem.vue';
import DragableMenuItem from './DragableMenuItem.vue';
import MenuDropZone from './MenuDropZone.vue';
import {faTrash} from '@fortawesome/free-solid-svg-icons'


export default {
    components: { DragableMenuItem, CustomMenuItem, MenuDropZone },
    data() {
        return {
            pages: [],
            menuItems: [],
            icons: {
                faTrash
            }
        }
    },
    computed: {
        showGroupPagesItem() {
            return !this.menuItems.find(m => m.special === "groupPages")
        }
    },
    methods: {
        async getPages() {
            try {
                const response = await this.callApi('get', 'pages');
                this.pages = response.data.data;
                const pagesAlreadyInMenu = this.menuItems.filter(menuItem => menuItem.pageId)
                this.pages = this.pages.filter(page => !pagesAlreadyInMenu.find(menuItem => menuItem.pageId === page.id))

            } catch (error) {
                console.log(error);
            }
        },
        async getMenuItems() {
            try {
                const response = await this.callApi('get', 'menuitems');
                this.menuItems = response.data.data;

            } catch (error) {
                console.log(error);
            }
        },
        async saveMenuItem(menuItem) {
            try {
                await this.callApi('post', 'menuitems', menuItem);
            } catch (error) {
                console.log(error);
            }
        },
        async deleteMenuItem(menuItem) {
            try {
                await this.callApi('delete', `menuitems/${menuItem.id}`);
            } catch (error) {
                console.log(error);
            }
        },
        async handleMenuZoneDrop(menuItem) {
            if (menuItem.type === "menuItem") {
                this.menuItems = this.menuItems.filter(mI => mI.id !== menuItem.id)
            } else if(menuItem.special === "groupPages"){
                menuItem = {
                    title: "Group Dropdown",
                    sort: menuItem.sort,
                    special: "groupPages"
                }
                
            }else {
                menuItem = {
                    page_id: menuItem.id,
                    title: menuItem.id ? undefined : menuItem.title,
                    url: menuItem.url,
                    sort: menuItem.sort,

                }
            }
            this.menuItems.push(menuItem)
            this.menuItems = this.menuItems.sort((a, b) => a.sort - b.sort)
            var i = 0;
            for (let mI of this.menuItems) {
                mI.sort = i;
                await this.saveMenuItem(mI)
                i++;
            }
            await this.getMenuItems()
            await this.getPages()
        },
        async handleDeleteDrop(e) {
            const item = JSON.parse(e.dataTransfer.getData("text/plain"))
            if (item.type === "menuItem") {
                await this.deleteMenuItem(item)
            }
            await this.getMenuItems();
            await this.getPages()
        }
    },
    async created() {
        await this.getMenuItems();
        await this.getPages();

}
}

</script>