<template>
    <div class="relative">
    <li @click="showDropdown=!showDropdown" class="min-w-[130px] flex flex-row space-x-2 items-center font-light p-3 py-5 md:py-0 md:p-0 hover:text-secondary text-white main-text md:text-2xl">
        <div>Gruppen</div>  <font-awesome-icon class="" :icon="icons.faCaretDown" />
        
    </li>
    <ul v-if="showDropdown" class="absolute z-10 bg-primary w-full">
        <li v-for="group in groups" :key="group.id" class="font-light p-3 py-5 pl-8 md:py-2 md:p-3 w-full md:px-5 hover:text-secondary text-white main-text md:text-2xl">
            <router-link @click="showDropdown=false" :to="`/group/${group.id}`">{{ group.name }}</router-link>
        </li>
    </ul>
    
</div>
</template>

<script>
import { faCaretDown } from "@fortawesome/free-solid-svg-icons";
export default {
    data(){
        return {
            groups: [],
            showDropdown: false,
            icons: {
                faCaretDown
            }
        }
    },
    methods: {
        async getGroups(){
            try{
                const response = await this.callApi('get', 'groups');
                this.groups = response.data.data;
            }catch(error){
                console.log(error);
            }
        }
    },
    created(){
        this.getGroups();
    }
}
</script>