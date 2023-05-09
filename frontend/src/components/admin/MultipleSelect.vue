<template>
    <label class="block text-gray-700 text-sm font-bold mb-1" for="">
      {{ label }}
    </label>
    <div class="relative" @mouseleave="showDropdown = false">
        <select @mousedown.prevent @click="handleClickSelect" class="appearance-none
        border
        relative
        rounded
        w-full
        py-2
        px-3
        text-gray-700
        leading-tight
        border-gray-500
        focus:outline-none focus:shadow-outline">
            <option selected :key="displayKey"> 
                {{ payload.length > 0 ? 
                options.filter(o => payload.includes(o.id)).map(o => o.name).join(",") :
                            "-" }}</option>
        </select>
        <div v-if="showDropdown" class="absolute bg-white z-30 rounded-lg w-full">
            <div v-for="option in options" class="p-2 m-1 hover:bg-gray-50 rounded-lg flex flex-row space-x-2 items-center">
                <input :checked="this.payload.includes(option.id)" @change="(event) => select(event, option.id)"
                    class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900" type="checkbox" />
                <div>{{ option.name }}</div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    components: {},
    emits: ["update:modelValue"],
    props: {
        label: {
            type: String
        },
        modelValue: {
        },
        options: {
            default: [
                { id: 1, name: "Apples" },
                { id: 2, name: "Oranges" },
                { id: 3, name: "Bananas" },
                { id: 4, name: "Grapes" },
                { id: 5, name: "Mangos" },
                { id: 6, name: "Pineapples" },
                { id: 7, name: "Watermelons" },
                { id: 8, name: "Strawberries" },
                { id: 9, name: "Blueberries" },
                { id: 10, name: "Raspberries" }
            ]
        }
    },
    data() {
        return {
            showDropdown: false,
            displayKey: 0

        }
    },
    methods: {
        handleClickSelect() {
            this.showDropdown = !this.showDropdown
        },
        select(event, objectid) {
            if (event.target.checked) {
                 this.payload.push(objectid)
            } else {
                this.payload = this.payload.filter(i => i !== objectid);
            }
            this.displayKey++;

        }

    },
    computed: {
        payload: {
            get() {
                return  this.modelValue || [];
            },
            set(value) {
                this.$emit("update:modelValue", value);
            },
        },
    },
}
</script>