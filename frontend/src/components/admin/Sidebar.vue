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
        <router-link to="/dashboard/pages">
            <div class="p-1 flex text-gray-50 rounded-lg border border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faBookOpen" class="h-6 w-6" />
                </div>
                <div class="text">Pages</div>
            </div>
        </router-link>
        <router-link to="/dashboard/groups">
            <div class="p-1 flex text-gray-50 rounded-lg border border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faUsers" class="h-6 w-6" />
                </div>
                <div class="text">Groups</div>
            </div>
        </router-link>
        <router-link to="/dashboard/contacts">
            <div class="p-1 flex text-gray-50 rounded-lg border border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faUser" class="h-6 w-6" />
                </div>
                <div class="text">Contacts</div>
            </div>
        </router-link>
        <router-link to="/dashboard/sections">
            <div class="p-1 flex text-gray-50 rounded-lg border border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faStairs" class="h-6 w-6" />
                </div>
                <div class="text">Sections</div>
            </div>
        </router-link>
        <router-link to="/dashboard/forms">
            <div class="p-1 flex text-gray-50 rounded-lg border  border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faRectangleList" class="h-6 w-6" />
                </div>
                <div class="text">Forms</div>
            </div>
        </router-link>
        <router-link to="/dashboard/media">
            <div class="p-1 flex text-gray-50 rounded-lg border  border-transparent hover:border-gray-50 m-0.5">
                <div class="px-5">
                    <font-awesome-icon :icon="icons.faPhotoVideo" class="h-6 w-6" />
                </div>
                <div class="text">Media</div>
            </div>
        </router-link>
    </div>
    <div @click="dMSb = !dMSb" :class="`flex items-center ${!dMSb ? 'hidden' : 'md:hidden'} bg-gray-900 text-white w-3`">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
</template>

<script>
import { faStairs, faBookOpen, faPhotoVideo, faUsers, faUser, faRectangleList } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {  },
    data() {
        return {
            dMSb: false,
            icons: {
               faStairs,
                faBookOpen,
               faPhotoVideo,
                faUsers,
               faUser,
                faRectangleList
            }
        }
    }
};
</script>

<style></style>
