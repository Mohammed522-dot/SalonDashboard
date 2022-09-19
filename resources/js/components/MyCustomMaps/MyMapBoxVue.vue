<template>
  <div id="app">
    <mapbox
      access-token="pk.eyJ1IjoiZGlzY291bnQiLCJhIjoiY2treWZ2am55MTAwajJxbzR1OGlobXhwdCJ9.cM845ShqfvX5HzEWJ0uJrg"
      :map-options="{
        style: 'mapbox://styles/mapbox/light-v9',
        center: [-96, 37.8],
        zoom: 3,
      }"
      @map-load="loaded"
      @map-click:points="clicked"
      @map-mouseenter:points="mouseEntered"
      @map-mouseleave:points="mouseLeft"
      :geolocate-control="{
        show: true,
        position: 'top-left',
      }"

      @geolocate-geolocate="geolocate"
    />
  </div>
</template>

<script>
import Mapbox from 'mapbox-gl-vue'
import PopupContent from './PopupContent.vue'


export default {
  components: { Mapbox },
  props:['id'],
  methods: {
    loaded(map) {
      map.addLayer({
        id: 'points',
        type: 'symbol',
        source: {
          type: 'geojson',
          data: {
            type: 'FeatureCollection',
            features: [
              {
                type: 'Feature',
                geometry: {
                  type: 'Point',
                  coordinates: [-15.5789275, 32.5505648],
                },
                properties: {
                  title: 'Mapbox DC',
                  icon: 'monument',
                },
              },
              {
                type: 'Feature',
                geometry: {
                  type: 'Point',
                  coordinates: [-15.5789275, 32.5505648],
                },
                properties: {
                  title: 'Mapbox SF',
                  icon: 'harbor',
                },
              },
            ],
          },
        },
        layout: {
          'icon-image': '{icon}-15',
          'text-field': '{title}',
          'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
          'text-offset': [0, 0.6],
          'text-anchor': 'top',
        },
      })
    },
    clicked(map, e) {
      if (e.features) {
        const coordinates = e.features[0].geometry.coordinates.slice()

        // Ensure that if the map is zoomed out such that multiple
        // copies of the feature are visible, the popup appears
        // over the copy being pointed to.
        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
          coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360
        }

        new mapboxgl.Popup()
          .setLngLat({ lng: coordinates[0], lat: coordinates[1] })
          .setHTML('<div id="vue-popup-content"></div>')
          .addTo(map)

        new PopupContent({
          propsData: { feature: e.features[0] },
        }).$mount('#vue-popup-content')
      }
    },
    mouseEntered(map) {
      map.getCanvas().style.cursor = 'pointer'
    },
    mouseLeft(map) {
      map.getCanvas().style.cursor = ''
    },
    geolocate(control, position) {
      console.log(
        `User position: ${position.coords.latitude}, ${position.coords.longitude}`
      )
    }
  },

  mounted(){
      console.log(" \n ID :  "+this.id+"  \n ");
  }
}
</script>

<style>
#map {
  width: 100%;
  height: 500px;
}
</style>




