<template>
    <router-link :to="to">
            <div class="p-1 flex text-gray-50 rounded-lg border border-transparent hover:border-gray-50 m-0.5"
            :class="{ 'bg-gray-50 text-gray-900': $route.path === to }">
                <div class="px-5">
                    <font-awesome-icon :icon="icon" class="h-6 w-6" />
                </div>
                <div class="text"><slot></slot></div>
            </div>
        </router-link>
</template>
<script>
export default {
    components: {},
    props: ["to", "icon"],
    data() {
        return {
            
        }
    },
    methods: {
        
    },
};
</script>