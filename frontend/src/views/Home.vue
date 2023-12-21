<template>
    <template v-if="page||group">
    <BigHeader v-if="!isGroupPage&&page.bigHeader" :page="page" />
    <SmallHeader v-if="!page?.bigHeader" :page="isGroupPage? {title: group.name, files: group.headerImages} : page" />
    <NavBar :menuItems="menuItems" @pageChange="handlePageChange" />
    <PageBuilder v-if="!isGroupPage" :page="page" :key="pageId" />
    <GroupPage v-if="isGroupPage" :group="group" />
    <Footer />
</template>
</template>
<script>
import BigHeader from '../components/main/BigHeader.vue';
import NavBar from '../components/main/NavBar.vue';
import PageBuilder from '../components/main/PageBuilder.vue';
import Footer from '../components/main/Footer.vue';
import SmallHeader from '../components/main/SmallHeader.vue';
import GroupPage from '../components/main/GroupPage.vue';

export default {
    name: 'App',
    components: { NavBar, BigHeader, PageBuilder, Footer, SmallHeader, GroupPage },
    data() {
        return {
            pageId: undefined,
            page: undefined,
            menuItems: [],
            isGroupPage: false,
            group: undefined
        }
    },
    methods: {
        async getPage() {
            this.isGroupPage = false
            var pageRoute = this.$route.path.substring(1)
            if(pageRoute===""){
                pageRoute = 0
            }
            if(this.$route.name==="GroupPage"){
                this.isGroupPage = true
                this.getGroup()
                return
            }
            try {
                const response = await this.callApi('get', `/pages/${pageRoute}`);
                this.page = response.data;
                document.title = `${this.page.title} | ${this.settings.divisionName}`;
            } catch (error) {
                console.log(error);
            }
        },
        async getMenuItems() {
            try {
                const response = await this.callApi('get', '/menuitems');
                this.menuItems = response.data.data;
            } catch (error) {
                console.log(error);
            }
        },
        async getGroup() {
            try {
                const response = await this.callApi('get', `/groups/${this.$route.params.id}`);
                this.group = response.data;
            }
            catch (error) {
                console.log(error);
            }
        },
        handlePageChange(pageId) {
            this.pageId = pageId;
            this.getPage();
        },


    },
    watch: {
    '$route'() {
      this.getPage()
    },
},
    async created() {
        await this.getMenuItems();
        if (!this.pageId && this.menuItems.length > 0) {
            this.pageId = this.menuItems.find(item => item.pageId).pageId;
        }
        await this.getPage();
        
        

    },
};
</script>
<style></style>