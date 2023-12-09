<template>
    <div :dropzone="true" @dragenter.prevent="" @dragover.prevent @drop="handleDrop" @dragenter="dragging=true" @dragleave="dragging=false" 
    :class="`${dragging?'h-48':'h-1.5'} bg-gray-400 rounded-lg`">
 </div>
</template>
<script>
export default {
    components: {},
    props: ["index",],
    emits: ["droppedItem"],
    data() {
        return {
            dragging: false,
            
        }
    },
    methods: {
        handleDrop(e){
            this.dragging=false
            const item = JSON.parse(e.dataTransfer.getData("text"))
            item.sort = this.index+0.5
            this.$emit("droppedItem", item);
        }
    },
};
</script>