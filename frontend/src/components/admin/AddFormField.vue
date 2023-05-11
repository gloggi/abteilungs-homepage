<template>
    <button @click="showModal = true" class="bg-gray-300 hover:bg-gray-400 rounded-lg my-1 h-1.5 w-full text-xs">
    </button>
    <Modal v-if="showModal" @close="close" title="Form Fields">
       <div class="grid grid-cols-4 gap-4">
        <div v-for="field in fields" :key="field.type" @click="select(field)" class="flex flex-col bg-gray-200 hover:bg-gray-300 rounded-lg p-3 space-y-2">
            <div class="w-full aspect-square bg-white rounded-lg flex justify-center items-center">
                <p class="font-serif text-8xl">{{ field.name.substring(0,1) }}</p>
                
            </div>
            <p class="font-semibold pl-5">{{ field.name }}</p>
        </div>
       </div>
    </Modal>
</template>
<script>
import Modal from './Modal.vue';

export default{
    data() {
        return {
            showModal: false,
            fields: [
                {name: "Textfeld", type: "textField", inputType: "text"},
                {name: "Zahlenfeld", type: "textField", inputType: "number"},
                {name: "Datum", type: "textField", inputType: "datum"},
                {name: "Uhrzeit", type: "textField", inputType: "time"},
                {name: "E-Mail", type: "textField", inputType: "email"},
                {name: "Textarea", type: "textArea"},
                {name: "Auswahlfeld", type: "selectField"},
            ]
        };
    },
    components: { Modal },
    methods:{
        close(){
            this.showModal= false
        },
        select(field){
            this.$emit("select", field);
            this.showModal= false
        }
    }
}
</script>