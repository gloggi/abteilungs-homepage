<template>
    <div class="border bg-gray-50 rounded-lg p-5 relative h-full">
        <div class="absolute z-10 -top-3 bg-inherit px-3 left-5 text-sm font-semibold">{{title}}</div>
        <slot></slot>
    </div>
</template>
<script>
export default {

    props: ["title"]
}

</script>