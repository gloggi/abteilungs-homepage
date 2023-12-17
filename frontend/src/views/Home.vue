<template>
    <BigHeader v-if="page.bigHeader" :page="page" />
    <SmallHeader v-else :page="page" />
    <NavBar :menuItems="menuItems" @pageChange="handlePageChange" />
    <PageBuilder :page="page" :key="pageId" />
    <Footer />
</template>
<script>
import BigHeader from '../components/main/BigHeader.vue';
import NavBar from '../components/main/NavBar.vue';
import PageBuilder from '../components/main/PageBuilder.vue';
import Footer from '../components/main/Footer.vue';
import SmallHeader from '../components/main/SmallHeader.vue';

export default {
    name: 'App',
    components: { NavBar, BigHeader, PageBuilder, Footer, SmallHeader },
    data() {
        return {
            pageId: undefined,
            page: undefined,
            menuItems: []
        }
    },
    methods: {
        async getPage() {
            var pageRoute = this.$route.path.substring(1)
            if(pageRoute===""){
                pageRoute = 0
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
        console.log(this.$route.path.substring(1))
        await this.getPage();
        
        

    },
};
</script>
<style></style>