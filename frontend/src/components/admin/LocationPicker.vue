<template>
    <div ref="mapContainer">
    </div>
</template>
  
<script>
import 'ol/ol.css';
import { Map, View } from "ol";
import { Tile as TileLayer, Vector as VectorLayer } from "ol/layer";
import { XYZ, Vector as VectorSource } from "ol/source";
import { fromLonLat, toLonLat } from 'ol/proj';
import { Icon, Style } from 'ol/style';
import Point from 'ol/geom/Point';
import Feature from 'ol/Feature';
import { defaults as defaultControls, ScaleLine } from "ol/control";

export default {
    props: ['lat', 'long'],
    emits: ['location-selected'],
    mounted() {
        this.initializeMap();
    },
    data() {
        return {
            map: undefined,
            markerPoint: undefined,
        };
    },
    methods: {
        initializeMap() {
            const vectorlayer = this.initializeIcon();
            this.map = new Map({
                target: this.$refs.mapContainer,
                layers: [
                    new TileLayer({
                        source: new XYZ({
                            url: `https://wmts.geo.admin.ch/1.0.0/ch.swisstopo.pixelkarte-farbe-pk25.noscale/default/current/3857/{z}/{x}/{y}.jpeg`
                        }),
                    }),
                    vectorlayer
                ],
                view: new View({
                    center: fromLonLat([this.long || 8.536, this.lat || 47.372]),
                    zoom: 14,
                }),
                controls: defaultControls().extend([
                    new ScaleLine({
                        units: "metric"
                    })
                ]),
            });
            this.map.on('singleclick', this.selectLocation);
            

        },
        initializeIcon() {
            const vectorSource = new VectorSource();   
            this.markerPoint = new Point(fromLonLat([this.long, this.lat])) 
            const iconFeature = new Feature({
                geometry: this.markerPoint,
            });

            const iconStyle = new Style({
                image: new Icon({
                    src: require('@/assets//mapMarker.svg'), // Replace with the URL to your icon image
                    scale: 4, 
                    anchor: [0.5, 1],
                }),
            });

            iconFeature.setStyle(iconStyle);

            vectorSource.addFeature(iconFeature);

            const vectorLayer = new VectorLayer({
                source: vectorSource,
            });

            return vectorLayer;

        },
        selectLocation(event) {
            {
                const pixel = event.pixel;
                const coords = this.map.getCoordinateFromPixel(pixel);
                this.markerPoint.setCoordinates(coords);
                const lonLat = toLonLat(coords);
                
                this.$emit('location-selected', { lat: lonLat[1], long: lonLat[0] });
            }
        }
    },
};
</script>
  
<style></style>
  