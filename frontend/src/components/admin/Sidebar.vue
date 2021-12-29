<template>
    <div @click="dMSb=!dMSb" :class="`flex items-center ${dMSb?'hidden':'md:hidden'} bg-gray-900 text-white w-3`">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
</svg>
    </div>
    <div :class="`bg-gray-900 w-64 md:flex flex-col md:rounded-r-lg ${dMSb?'flex':'hidden'}`">
        <div class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 text-center mx-auto p-5">
            Abteilungs Homepage
        </div>
        <router-link to="/dashboard/pages">
        <div class="p-3 flex text-gray-50 rounded-lg border  border-transparent hover:border-gray-50 m-2">
            <div class="px-5">
                <BookIcon />
            </div>
            <div class="text">Pages</div>
        </div>
        </router-link>
    </div>
    <div @click="dMSb=!dMSb" :class="`flex items-center ${!dMSb?'hidden':'md:hidden'} bg-gray-900 text-white w-3`">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
</svg>
    </div>
</template>

<script>
import BookIcon from '../../icons/BookIcon.vue';
export default {
  components: { BookIcon },
    data(){
        return {
            dMSb: false
        }
    }
};
</script>

<style></style>
