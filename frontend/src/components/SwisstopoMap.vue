<template>
    <l-map
        ref="leafletMap"
        style="height: 100%; width: 100%"
        :zoom.sync="zoom"
        :center.sync="center"
        :crs="crs">
        <l-tile-layer :tile-layer-class="tileLayerClass"></l-tile-layer>
        <l-marker :lat-lng="startLocation" :icon="markerIcon"></l-marker>
        <l-marker v-if="startLocation !== endLocation" :lat-lng="endLocation" :icon="markerIcon"></l-marker>
    </l-map>
</template>

<script>
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'
import 'leaflet-tilelayer-swiss'
import L from 'leaflet'

// coordinate reference system LV95+ (converts between LatLng and swiss coordinates)
const crs = L.CRS.EPSG2056

export default {
    name: "SwisstopoMap",
    components: { LMap, LTileLayer, LMarker },
    props:["settings", "startLoc", "endLoc"],
    data () {
        return {
            zoom: 20,
            center: crs.unproject(this.startLoc)
        };
    },
    computed: {
        crs() {
            return crs
        },
        tileLayerClass() {
            return L.tileLayer.swiss;
        },
        startLocation() {
            return crs.unproject(this.startLoc)
        },
        endLocation() {
            if (!this.endLoc) return this.startLocation
            return crs.unproject(this.endLoc)
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
    },
    mounted() {
        if (this.endLocation.lat !== this.startLocation.lat || this.endLocation.lng !== this.startLocation.lng) {
            this.$nextTick(() => {
                const markers = new L.featureGroup([new L.Marker(this.startLocation), new L.Marker(this.endLocation)]);
                this.$refs.leafletMap.mapObject.fitBounds(markers.getBounds(), {paddingTopLeft: [15, 50], paddingBottomRight: [15, 0], maxZoom: 22});
            });
        }
    }
};
</script>
