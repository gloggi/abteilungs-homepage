<template>
    <BigHeader :page="page" />
    <NavBar :menuItems="menuItems" @pageChange="handlePageChange" />
    <PageBuilder :page="page" :key="pageId" />
    <Footer />
</template>
<script>
import BigHeader from '../components/main/BigHeader.vue';
import NavBar from '../components/main/NavBar.vue';
import PageBuilder from '../components/main/PageBuilder.vue';
import Footer from '../components/main/Footer.vue';

export default {
    name: 'App',
    components: { NavBar, BigHeader, PageBuilder, Footer },
    data() {
        return {
            pageId: undefined,
            page: undefined,
            menuItems: []
        }
    },
    methods: {
        async getPage() {
            try {
                const response = await this.callApi('get', `/pages/${this.pageId}`);
                this.page = response.data;
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
        handlePageChange(pageId) {
            this.pageId = pageId;
            this.getPage();
        },


    },
    async created() {
        await this.getMenuItems();
        if (!this.pageId && this.menuItems.length > 0) {
            this.pageId = this.menuItems.find(item => item.pageId).pageId;
        }
        await this.getPage();
        document.title = this.page.title;
        

    },
};
</script>
<style></style>