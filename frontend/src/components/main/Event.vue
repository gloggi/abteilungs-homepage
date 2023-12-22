<template>
    <div>
        <div class="w-full px-24">
            <div class="w-full bg-primary p-5 flex flex-col text-white">
                <HeadingOne >{{ event.title }}</HeadingOne>
                <div class="flex flex-col">
                <p class="main-text text-white text-xl"><span class="font-semibold">Datum:</span> {{ formatDate(event.startTime) }}</p>
                <p class="main-text text-white text-xl"><span class="font-semibold">Zeit:</span> {{ formatTime(event.startTime) }} - {{ formatTime(event.endTime) }}</p>
            </div>
            <p class="main-text text-white text-xl"><span class="font-semibold">Ort:</span> {{ event.startLocation.name }}</p>
            <p v-if="event.groups.length>1" class="main-text text-white text-xl"><span class="font-semibold">Gruppen:</span> {{ event.groups.map(g=>g.name).join(", ") }}</p>
            </div>
            <Map class="w-full h-96" :markers="[event.startLocation, event.endLocation]" />
            <div class="p-3" v-html="event.description" v-router-link></div>
        </div>
    </div>
</template>
<script>
import HeadingOne from './HeadingOne.vue';
import Map from './Map.vue';
import {format} from 'date-fns';
import { de } from 'date-fns/locale'

export default {
    props: ["event"],
    components: { HeadingOne, Map },
    methods: {
        formatDate(date){
            return format(new Date(date), 'dd. MMMM yyyy', {locale: de})
        },
        formatTime(date){
            return format(new Date(date), 'HH:mm')
    },
}

}
</script>