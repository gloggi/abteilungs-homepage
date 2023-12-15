<template>
    <div class="flex flex-col">
    <FormLabel v-if="label">{{ label }}</FormLabel>
    <input type="checkbox" v-model="checkboxValue"
        class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-400 h-[38px] w-[38px]">
    </div>
</template>
<script>
import FormLabel from './FormLabel.vue';

export default {
    props: ["modelValue", "label"],
    computed: {
        checkboxValue: {
            get() {
                return this.modelValue? true : false;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            }
        }
    },
    components: { FormLabel }
}
</script>