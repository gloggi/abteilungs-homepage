<template>
<ItemBox class="flex items-center justify-center space-x-2 p-0 py-3">
            <div class=""><font-awesome-icon :icon="icons.faGripVertical"/></div>
            <div class="w-full">
             <slot></slot>
            </div>
            <div class="p-3"><font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" /></div>
          </ItemBox>
</template>
<script>
import ItemBox from './ItemBox.vue';
import { faTrash, faGripVertical } from "@fortawesome/free-solid-svg-icons";

export default {
    components: { ItemBox },
    data() {
        return {
            icons:{
                faGripVertical,
                faTrash

            }
        }
    },
}
</script>