<template>
    <l-map
        style="height: 100%; width: 100%"
        :zoom.sync="zoom"
        :center.sync="center"
        :crs="crs">
        <l-tile-layer :tile-layer-class="tileLayerClass"></l-tile-layer>
        <l-marker :lat-lng="startLocation" :icon="markerIcon">
            X
        </l-marker>
    </l-map>
</template>

<script>
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'
import 'leaflet-tilelayer-swiss'
import L from 'leaflet'

export default {
    name: "Map",
    components: { LMap, LTileLayer, LMarker },
    props:["settings", "start_loc_lat", "start_loc_lng", "end_loc_lat", "end_loc_lng"],
    data () {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            zoom: 20,
            center: [this.start_loc_lat, this.start_loc_lng]
        };
    },
    computed: {
        crs() {
            return L.CRS.EPSG2056
        },
        tileLayerClass() {
            return L.tileLayer.swiss;
        },
        startLocation() {
            return [this.start_loc_lat, this.start_loc_lng]
        },
        markerIcon() {
            return L.icon({
                iconUrl: this.markerIconDataUrl,
                iconSize:     [26, 50],
                iconAnchor:   [13, 49],
            })
        },
        markerIconDataUrl() {
            const svgStr = '<svg width="26" height="50" version="1.1" viewBox="0 0 26 50" xmlns="http://www.w3.org/2000/svg">' +
                    '<path class="svg" d="m8 1-1e-7 20h-7s12 19 12 28c0-9 12-28 12-28h-7v-20z" stroke="#fff" fill="' + this.settings.primary_color + '" stroke-width="2"/>' +
                    '</svg>'
            return 'data:image/svg+xml,' + encodeURIComponent(svgStr)
                .replace(/'/g, '%27')
                .replace(/"/g, '%22')
        }
    }
};
</script>
