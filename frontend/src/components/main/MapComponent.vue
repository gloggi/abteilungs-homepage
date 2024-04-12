<template>
  <div ref="mapContainer"></div>
</template>

<script>
import "ol/ol.css";
import { Map, View } from "ol";
import { Tile as TileLayer, Vector as VectorLayer } from "ol/layer";
import { XYZ, Vector as VectorSource } from "ol/source";
import { fromLonLat } from "ol/proj";
import { Icon, Style, Text, Fill, Stroke } from "ol/style";
import { boundingExtent } from "ol/extent";
import Point from "ol/geom/Point";
import Feature from "ol/Feature";
import { defaults as defaultControls, ScaleLine } from "ol/control";

export default {
  props: ["markers", "markerTexts"],
  async mounted() {
    this.sameLocations = this.markers.every(
      (marker, index, array) =>
        marker.lat === array[0].lat && marker.long === array[0].long,
    );
    this.initializeMap();
  },
  data() {
    return {
      map: undefined,
      sameLocations: false,
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
    getIconStyle(text) {
      return new Style({
        image: new Icon({
          src: this.formatIcon(),
          height: 50,
          anchor: [0.5, 1],
        }),
        text: new Text({
          text,
          offsetY: -58,
          fill: new Fill({
            color: this.settings.primaryColor,
          }),
          stroke: new Stroke({
            color: "#ffff",
            width: 4,
          }),
          font: "semibold 16px Source Sans Pro, system-ui",
        }),
      });
    },
    initializeMarkers() {
      const vectorSource = new VectorSource();
      var coordinates = this.markers.map((marker) => {
        return fromLonLat([marker.long, marker.lat]);
      });

      var extent = boundingExtent(coordinates);

      for (let i = 0; i < this.markers.length; i++) {
        const markerPoint = new Point(
          fromLonLat([this.markers[i].long, this.markers[i].lat]),
        );
        const iconFeature = new Feature({
          geometry: markerPoint,
        });
        const markerText =
          this.markerTexts &&
          this.markerTexts.length - 1 >= i &&
          !this.sameLocations
            ? this.markerTexts[i]
            : undefined;
        iconFeature.setStyle(this.getIconStyle(markerText));

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

<style>
.ol-control button {
  color: var(--primary-color);
}
.ol-control button:hover {
  color: var(--secondary-color);
  border-color: var(--secondary-color);
}
</style>
