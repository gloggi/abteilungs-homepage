<template>
  <div :draggable="allowDrag" @dragstart="dragStart" @dragend="dragEnd" class="flex flex-col text-left rounded-lg p-3 bg-gray-200">
    <div id="dragbutton" class="w-full flex justify-center text-gray-300" @mouseover="allowDrag=true" @mouseleave="allowDrag=false" >
            <font-awesome-icon :icon="icons.faGripHorizontal" />
        </div>
    <slot></slot>
    </div>
</template>
<script>
import { faGripHorizontal } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {},
    props: ["item"],
    emits: ["startedDragging", "endedDragging"],
    data() {
        return {
            allowDrag: false,
            icons: {
                faGripHorizontal
            }
            
        }
    },
    methods:{
        dragStart(e){
            e.dataTransfer.setData("text/plain", JSON.stringify(this.item) );
            this.$emit("startedDragging", true)
        },
        dragEnd(){
            this.allowDrag = false
            this.$emit("endedDragging", true)
        },
    }
};
</script>