<template>
  <div class="interface-map">
    <div :class="{ 'map-readonly': readonly }" class="map">
      <div :id="name" class="map-container" :style="{ height: options.height + 'px' }">
        <!-- Map Renders Here -->
      </div>

      <div class="map-actions">
        <form @submit.prevent="getCoordinatesforPlaceName()" v-if="options.address_to_code" class="address-input">
          <v-input v-model="placeName" placeholder="Adresse"></v-input>
          <button type="submit"
                  v-if="isInteractive"
                  v-tooltip="$t('interfaces.map.address_location')"
          >
            <v-icon name="search"/>
          </button>
        </form>

        <button
                v-if="isInteractive"
                v-tooltip="$t('interfaces.map.clear_location')"
                class="clear-location"
                @click="setValue()"
        >
          <v-icon name="clear"/>
        </button>
      </div>
    </div>

    <div class="map-coordinates">
			<span v-if="value">
				<b>{{ value.x | coord }} / {{ value.y | coord }}</b>
      </span>
    </div>
  </div>
</template>

<script>
  import mixin from '@directus/extension-toolkit/mixins/interface'
  import leaflet from 'leaflet'
  import './leaflet.css'
  import 'leaflet-tilelayer-swiss'
  import {debounce} from 'lodash'

  export default {
    name: 'InterfaceSwisstopoMap',
    mixins: [mixin],
    data() {
      return {
        test: null,
        map: null,
        marker: null,
        isLocating: false,
        placeName: '',
        mapInteractions: [
          'boxZoom',
          'doubleClickZoom',
          'dragging',
          'keyboard',
          'scrollWheelZoom',
          'tap',
          'touchZoom'
        ]
      }
    },
    computed: {
      isInteractive() {
        return !this.readonly
      },
      accentColor() {
        return getComputedStyle(document.documentElement)
        .getPropertyValue('--blue-grey-900')
        .trim()
      },
      darkAccentColor() {
        return getComputedStyle(document.documentElement)
        .getPropertyValue('--blue-grey-900')
        .trim()
      }
    },
    watch: {
      readonly(status) {
        this.toggleMapInteractions(!status)
        this.toggleMarkerInteractions(!status)
        if (status) {
          this.unbindMapEvents()
          this.unbindMarkerEvents()
        } else {
          this.bindMapEvents()
          this.bindMarkerEvents()
        }
      }
    },
    mounted() {
      this.init()
    },
    filters: {
      coord(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      }
    },
    methods: {
      init() {
        let _latlng
        /**
         * If value is provided on initialization,
         * map should be centered at lat/lng of value
         * else it should center at provided default location.
         */
        if (this.value) {
          _latlng = leaflet.latLng(leaflet.CRS.EPSG2056.unproject(leaflet.point(this.value.x, this.value.y)))
        } else {
          _latlng = leaflet.latLng(leaflet.CRS.EPSG2056.unproject(leaflet.point(this.options.mapLat, this.options.mapLng)))
        }
        this.createMap(_latlng)
      },
      createMap(latlng) {
        this.map = leaflet.map(this.name, {
          center: latlng,
          zoom: this.options.defaultZoom,
          maxZoom: this.options.maxZoom,
          zoomControl: true,
          crs: leaflet.CRS.EPSG2056
        })
        leaflet.tileLayer.swiss().addTo(this.map)
        /**
         * Render marker only if value is set.
         */
        this.value ? this.setValue(this.value) : ''
        /**
         * Bind interaction method only in "input" mode
         * For "display" mode, interactions are not required.
         */
        this.isInteractive ? this.bindMapEvents() : this.unbindMapEvents()
      },
      /**
       * Handles Marker Positioning
       */
      setMarker(coords) {
        if (this.marker) {
          //Hide marker if coords is provided NULL
          if (coords) {
            this.marker.setLatLng(leaflet.CRS.EPSG2056.unproject(coords)).setOpacity(1)
          } else {
            this.marker.setOpacity(0)
          }
        } else if (coords) {
          // Create a Marker Instance
          let markerIcon = leaflet.icon({
            iconUrl: this.markerSVG(),
            iconSize: [36, 36],
            iconAnchor: [18, 36]
          })
          // Set marker on the position
          this.marker = leaflet
          .marker(leaflet.CRS.EPSG2056.unproject(coords), {
            icon: markerIcon,
            draggable: this.isInteractive
          })
          .addTo(this.map)
          if (this.isInteractive) {
            this.bindMarkerEvents()
            this.toggleMapInteractions(true)
          }
        }
      },
      /**
       * Always this function will emit the value.
       * Passing NULL will remove values & hide marker
       */
      setValue(coords) {
        this.value = coords ? {x: Math.floor(coords.x), y: Math.floor(coords.y)} : null
        this.latlng = this.value ? leaflet.CRS.EPSG2056.unproject(this.value) : null
        this.setMarker(this.value)
        this.$emit('input', this.value ? JSON.parse(JSON.stringify(this.value)) : null)
      },
      toggleMarkerInteractions(status) {
        status ? this.marker.dragging.enable() : this.marker.dragging.disable()
      },
      unbindMarkerEvents() {
        this.marker.off('drag')
      },
      bindMarkerEvents() {
        // Handle drag event of marker.
        this.marker.on(
          'drag',
          debounce(e => {
            this.setValue(leaflet.CRS.EPSG2056.project(e.latlng))
          }, 100)
        )
      },
      toggleMapInteractions(status) {
        /**
         * Loop through all the possible interaction option & set status
         */
        this.mapInteractions.forEach(item => {
          if (this.map[item]) {
            status ? this.map[item].enable() : this.map[item].disable()
          }
        })
      },
      unbindMapEvents() {
        this.map.off('click')
      },
      bindMapEvents() {
        /**
         * Handle click event on the map.
         * This will place marker on clicked point.
         */
        this.map.on('click', e => {
          this.setValue(leaflet.CRS.EPSG2056.project(e.latlng))
        })
      },
      markerSVG() {
        const svgStr = '<svg width="26" height="50" version="1.1" viewBox="0 0 26 50" xmlns="http://www.w3.org/2000/svg">' +
          '<path class="svg" d="m8 1-1e-7 20h-7s12 19 12 28c0-9 12-28 12-28h-7v-20z" stroke="#fff" fill="#D22630" stroke-width="2"/>' +
          '</svg>'
        return 'data:image/svg+xml,' + encodeURIComponent(svgStr)
        .replace(/'/g, '%27')
        .replace(/"/g, '%22')
      },
      // Place name for geocode lookup on openstreetmap database via Nominatim, Returns coordinates in [lat,lon]
      getCoordinatesforPlaceName() {
        this.$store.dispatch('loadingStart', {
          id: this.isLocating
        })
        this.$axios
        .get(
          `https://nominatim.openstreetmap.org/search?q=${encodeURI(
            this.placeName
          )}&format=geojson&addressdetails=1&limit=1`
        )
        .then(response => {
          if (response.status === 200) {
            if (!response.data.features[0]) {
              this.$events.emit('error', {
                notify: this.$t('interfaces.map.address_to_code_error'),
                error: 'result'
              })
            } else {
              let coordArray = response.data.features[0].geometry.coordinates
              let coordinates = {
                lat: coordArray[1],
                lng: coordArray[0]
              }
              this.setValue(leaflet.CRS.EPSG2056.project(coordinates))
              this.map.panTo(new leaflet.LatLng(coordArray[1], coordArray[0]))
              this.$store.dispatch('loadingFinished', this.isLocating)
            }
          }
        })
        .catch(err => {
          this.$events.emit('error', {
            notify: err,
            error: 'result'
          })
          this.$store.dispatch('loadingFinished', this.isLocating)
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .interface-map {
    overflow-x: auto;
    overflow-y: hidden;
    position: relative;
  }

  .map {
    transition: all var(--fast) var(--transition);
    position: relative;
    display: flex;
    flex-direction: column;
    border: var(--input-border-width) solid var(--input-border-color);
    border-radius: var(--border-radius);

    &:hover {
      border-color: var(--input-border-color-hover);
    }
  }

  .map-container {
    z-index: 1;
    width: 100%;
    //This is fallback size. Generally this will be overwritten by default size provided in interface config.
    height: var(--width-medium);
  }

  .map-actions {
    position: absolute;
    display: flex;
    width: 100%;
    top: 20px;
    left: 0px;
    padding: 0 20px;
    z-index: 2;
  }

  .address-input {
    display: flex;

    .v-input {
      width: 250px;
      margin-right: 8px;
    }

    button {
      transition: all var(--fast) var(--transition);
      width: 44px;
      height: 44px;
      border-radius: var(--border-radius);
      color: var(--white);
      background: var(--blue-grey-200);
      margin-right: 8px;

      &:hover {
        background: var(--blue-grey-300);
      }
    }
  }

  .clear-location {
    transition: var(--fast) var(--transition) color;
    height: 44px;
    width: 44px;
    border-radius: var(--border-radius);
    color: var(--white);
    background: var(--blue-grey-200);
    margin-right: 8px;

    &:hover {
      background: var(--blue-grey-300);
    }
  }

  .map-coordinates {
    position: absolute;
    bottom: 2px;
    left: 2px;
    z-index: 1;
    padding: 4px 8px 4px 4px;
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 0 var(--border-radius) 0 0;

    span {
      color: var(--blue-grey-300);
      text-transform: initial;
      font-style: italic;
    }
  }

  //Read Only Map
  .map-readonly {
    .map-container {
      filter: grayscale(100%);
      opacity: 0.8;
    }
  }

  @media only screen and (max-width: 800px) {
    .map {
      display: flex;
    }
  }
</style>