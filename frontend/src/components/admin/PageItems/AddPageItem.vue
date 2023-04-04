<template>
    <Popover class="relative">
        <PopoverButton
            class="bg-gray-300 hover:bg-gray-400 rounded-lg my-1 h-1.5 w-full"
        ></PopoverButton>
        <Fade>
            <PopoverPanel
                class="absolute z-10 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
            >
                <div
                    class="flex flex-col rounded-lg bg-gray-50 shadow p-2 w-64 items-stretch"
                >
                    <button
                        class="rounded-lg p-2 hover:bg-gray-200 flex justify-center w-full"
                        @click="createNewItem('text')"
                    >
                         <BookIcon />
                        <div class="ml-2">Add Text item</div>
                    </button>
                    <button
                        class="rounded-lg p-2 hover:bg-gray-200 flex justify-center w-full"
                        @click="createNewItem('image')"
                    >
                       
                        <PhotographIcon class="h-6 w-6 " />
                        <div class="ml-2">Add Image item</div>
                    </button>
                
                </div>
            </PopoverPanel>
        </Fade>
    </Popover>
</template>

<script>
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import BookIcon from "../../../icons/BookIcon.vue";
import Fade from '../../../transitions/Fade.vue';
import { PhotographIcon } from '@heroicons/vue/solid'

export default {
    components: { Popover, PopoverButton, PopoverPanel, BookIcon, Fade, PhotographIcon },
    props: ["position"],
    methods:{
        emit(type){
            console.log(type)
            this.$emit("addComponent", {type, position: this.position})

        },
        async createNewItem(type){
            await this.$store.commit("pageInEdit/addItem",type)
        }
    }
};
</script>
