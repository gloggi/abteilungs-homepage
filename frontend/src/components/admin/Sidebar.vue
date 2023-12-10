<template>
    <div @click="dMSb = !dMSb" :class="`flex items-center ${dMSb ? 'hidden' : 'md:hidden'} bg-gray-900 text-white w-3`">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </div>
    <div :class="`bg-gray-900 w-64 md:flex flex-col md:rounded-r-lg ${dMSb ? 'flex' : 'hidden'}`">
        <router-link to="/dashboard">
            <div
                class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 text-center mx-auto p-5 cursor-pointer">
                A
            </div>
        </router-link>
        <SidebarItem to="/dashboard/menu" :icon="icons.faEllipsis">
            Menu
        </SidebarItem>
        <SidebarItem to="/dashboard/pages" :icon="icons.faBookOpen">
            Pages
        </SidebarItem>
        <SidebarItem to="/dashboard/groups" :icon="icons.faUsers">
            Groups
        </SidebarItem>
        <SidebarItem to="/dashboard/contacts" :icon="icons.faUser">
            Contacts
        </SidebarItem>
        <SidebarItem to="/dashboard/sections" :icon="icons.faStairs">
            Sections
        </SidebarItem>
        <SidebarItem to="/dashboard/locations" :icon="icons.faLocationDot">
            Locations
        </SidebarItem>
        <SidebarItem to="/dashboard/forms" :icon="icons.faRectangleList">
            Forms
        </SidebarItem>
        <SidebarItem to="/dashboard/media" :icon="icons.faPhotoVideo">
            Media
        </SidebarItem>
        <SidebarItem to="/dashboard/settings" :icon="icons.faGear">
            Settings
        </SidebarItem>

    </div>
    <div @click="dMSb = !dMSb" :class="`flex items-center ${!dMSb ? 'hidden' : 'md:hidden'} bg-gray-900 text-white w-3`">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
</template>

<script>
import { faStairs, faBookOpen, faPhotoVideo, faUsers, faUser, faRectangleList, faEllipsis, faGear, faLocationDot } from "@fortawesome/free-solid-svg-icons";
import SidebarItem from "./SidebarItem.vue";
export default {
    components: { SidebarItem },
    data() {
        return {
            dMSb: false,
            icons: {
                faStairs,
                faBookOpen,
                faPhotoVideo,
                faUsers,
                faUser,
                faRectangleList,
                faEllipsis,
                faGear,
                faLocationDot

            }
        }
    }
};
</script>

<style></style>
