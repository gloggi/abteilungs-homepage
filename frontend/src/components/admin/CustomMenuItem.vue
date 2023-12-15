<template>
    <div :draggable="allowDrag" @dragstart="dragStart" @dragend="dragEnd"
        class="flex flex-col rounded-md bg-white text-left">

        <div class="rounded-t-lg bg-gray-200 p-3">
            <div id="dragbutton" class="w-full flex justify-center text-gray-400" @mouseover="allowDrag = true"
                @mouseleave="allowDrag = false">
                <font-awesome-icon :icon="icons.faGripHorizontal" />
            </div>
            <TextInput label="Title" v-model="customMenuItem.title" />
        </div>
        <div class="p-3">
            <TextInput label="URL" placeholder="https://" v-model="customMenuItem.url" />
        </div>
    </div>
</template>
<script>
import TextInput from './TextInput.vue';
import { faGripHorizontal } from "@fortawesome/free-solid-svg-icons";

export default {
    components: { TextInput },
    props: ["item"],
    emits: ["startedDragging", "endedDragging"],
    data() {
        return {
            customMenuItem: {
                title: "Google",
                url: "https://google.com",
                type: "customItem"
            },
            allowDrag: false,
            icons: {
                faGripHorizontal
            }

        }
    },
    methods: {
        dragStart(e) {
            e.dataTransfer.setData("text/plain", JSON.stringify(this.customMenuItem));
           
            this.$emit("startedDragging", true)
        },
        dragEnd() {
           
            this.allowDrag = false
            this.$emit("endedDragging", true)
        }
    }
};

</script>