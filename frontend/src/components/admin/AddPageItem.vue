<template>
    <Popover class="relative">
        <PopoverButton
            class="bg-gray-300 hover:bg-gray-400 rounded-lg my-1 h-1.5 w-full"
        ></PopoverButton>
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-1 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-1 opacity-0"
        >
            <PopoverPanel
                class="absolute z-10 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
            >
                <div
                    class="flex flex-col rounded-lg bg-gray-50 shadow p-2 w-64 items-stretch"
                >
                    <div
                        class="rounded-lg p-2 hover:bg-gray-200 flex justify-center w-full"
                        @click="()=>{emit('text_items')}"
                    >
                        <BookIcon />
                        <div class="ml-2">Add Text item</div>
                    </div>
                    <div
                        class="rounded-lg p-2 hover:bg-gray-200 flex justify-center w-full"
                    >
                        <BookIcon />
                        <div class="ml-2">Add Text item</div>
                    </div>
                    <div
                        class="rounded-lg p-2 hover:bg-gray-200 flex justify-center w-full"
                    >
                        <BookIcon />
                        <div class="ml-2">Add Text item</div>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>

<script>
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import BookIcon from "../../icons/BookIcon.vue";

export default {
    components: { Popover, PopoverButton, PopoverPanel, BookIcon },
    props: ["position"],
    methods:{
        emit(type){
            console.log(type)
            this.$emit("addComponent", {type, position: this.position})

        }
    }
};
</script>
