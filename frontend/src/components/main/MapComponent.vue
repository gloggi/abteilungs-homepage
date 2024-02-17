<template>
  <div ref="mapContainer"></div>
</template>

<script>
import "ol/ol.css";
import { Map, View } from "ol";
import { Tile as TileLayer, Vector as VectorLayer } from "ol/layer";
import { XYZ, Vector as VectorSource } from "ol/source";
import { fromLonLat } from "ol/proj";
import { Icon, Style } from "ol/style";
import { boundingExtent } from "ol/extent";
import Point from "ol/geom/Point";
import Feature from "ol/Feature";
import { defaults as defaultControls, ScaleLine } from "ol/control";

export default {
  props: ["markers"],
  async mounted() {
    await this.initializeMap();
  },
  data() {
    return {
      map: undefined,
    };
  },
  methods: {
    initializeMap() {
      const [extent, vectorlayer] = this.initializeMarkers();
      this.map = new Map({
        target: this.$refs.mapContainer,
        layers: [
          new TileLayer({
            source: new XYZ({
              url: `https://wmts.geo.admin.ch/1.0.0/ch.swisstopo.pixelkarte-farbe-pk25.noscale/default/current/3857/{z}/{x}/{y}.jpeg`,
            }),
          }),
          vectorlayer,
        ],
        view: new View({
          center: fromLonLat([this.long || 8.536, this.lat || 47.372]),
          zoom: 14,
        }),
        controls: defaultControls().extend([
          new ScaleLine({
            units: "metric",
          }),
        ]),
      });
      this.map.getView().fit(extent, {
        padding: [50, 50, 50, 50],
        maxZoom: 16,
      });
    },
    formatIcon() {
      const svgString = `<svg width='26' height='50' version='1.1' viewBox='0 0 26 50' xmlns='http://www.w3.org/2000/svg'>
                            <path class='svg' d='m8 1-1e-7 20h-7s12 19 12 28c0-9 12-28 12-28h-7v-20z' 
                            stroke='#fff' fill='${this.settings.primaryColor}' stroke-width='2'/>
                            </svg>`;
      const svgBlob = new Blob([svgString], { type: "image/svg+xml" });
      return URL.createObjectURL(svgBlob);
    },
    initializeMarkers() {
      const vectorSource = new VectorSource();
      var coordinates = this.markers.map((marker) => {
        return fromLonLat([marker.long, marker.lat]);
      });
      const markerIcon = this.formatIcon();

      var extent = boundingExtent(coordinates);
      const iconStyle = new Style({
        image: new Icon({
          src: markerIcon,
          scale: 1,
          anchor: [0.5, 1],
        }),
      });

      for (let marker of this.markers) {
        const markerPoint = new Point(fromLonLat([marker.long, marker.lat]));
        const iconFeature = new Feature({
          geometry: markerPoint,
        });

        iconFeature.setStyle(iconStyle);

        vectorSource.addFeature(iconFeature);
      }

      const vectorLayer = new VectorLayer({
        source: vectorSource,
      });

      return [extent, vectorLayer];
    },
  },
};
</script>

<style></style>
