<template>
    <div class="flex">
        <div class="flex flex-col justify-center items-center w-screen h-screen pb-[75px]">
            <div class="flex flex-col justify-between items-center w-full h-2/3 text-center">
                <img class="drop-shadow-xl max-h-full" :src="`${backendURL}${settings?.divisionLogo?.path}`" />
                <h1 class="text-5xl md:text-8xl font-semibold text-white text-header-1">{{settings.siteTitle}}</h1>
            </div>
        </div>     
        <img class="fixed -z-10 h-screen w-screen object-cover" :src="`${backendURL}${page?.files[0]?.path}`">
        
        
    </div>
</template>
<script>
export default {
    props: ['page'],
}
</script>