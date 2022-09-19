<template>
	<div class="container">
		<h1>
			 المةقع الجغرافي
		</h1>

		<ul class="list-inline">

      <li class="list-inline-item"
            :key="index"
            v-for="(m, index) in markers"
            :position="m.position"
            :icon="m.icon"
            :clickable="true"
            :label="m.label"
            @click="openWindow(m, index)"
        >

        <div class="row mb-2">
          <div class="col-4">
            <img :src=" m.prev " alt="" class="img-fluid">
          </div>

          <div class="col-8">
            <h3>
              {{m.name}}
            </h3>
            <strong>
              {{m.label.text}} $
            </strong>
          </div>
        </div>

      </li>
		</ul>

		<gmap-map id="map" v-bind="options" v-bind:options="mapStyle">

	    	<gmap-marker
	            :key="index"
	            v-for="(m, index) in markers"
	            :position="m.position"
                :icon="m.icon"
	            :clickable="true"
	            :label="m.label"
	            @click="openWindow(m, index)"
	        />

	        <gmap-info-window
                @closeclick="window_open=false"
                :opened="window_open"
                :position="infoPosition"
                :options="infoOptions"
            >

            </gmap-info-window>
	    </gmap-map>

        <br>
        <br>

       <div class="map">
 <center><h2>My Location</h2></center>
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7683.025042636679!2d32.477230682037614!3d15.670926188910332!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6f87e1d95b7004e9!2sUniversity+of+Science+and+Technology!5e0!3m2!1sen!2s!4v1461700738850" width="1100" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>

<p ></p>
<p ></p>


<small><a style="color: #0000ff; text-align: left;" href="http://maps.google.be/maps?f=q&source=embed&             hl=nl&geocode=&q=lanklaar+belgie&aq=&sll=50.805935,4.432983&sspn=4.6801,11.634521&vpsrc=0&ie=UTF8&             hq=&hnear=Lanklaar,+Limburg,+Vlaams+Gewest&t=m&z=14&ll=51.0188,5.7262">
          <a href="https://www.google.com/maps/place/University+of+Science+and+Technology/@15.671515,32.4790975,15z/data=!4m2!3m1!1s0x0:0x6f87e1d95b7004e9" class="btn"> بحجم اكبر <span class="icon">   E</span></a>
</a></small>

</div>


	</div>
</template>


<script>
import { gmapApi } from "vue2-google-maps";
import { locations } from "./data.json";



export default {
  name: "GoogleMap",
  data() {
    return {
      dialogMap:false,
      options: {
        zoom: 12,
        center: {
          lat: 39.9995601,
          lng: -75.1395161
        },
        mapTypeId: "roadmap",

      },
      mapStyle: {
        styles: [
                  {
                      "featureType": "water",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#e9e9e9"
                          },
                          {
                              "lightness": 17
                          }
                      ]
                  },
                  {
                      "featureType": "landscape",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#f5f5f5"
                          },
                          {
                              "lightness": 20
                          }
                      ]
                  },
                  {
                      "featureType": "road.highway",
                      "elementType": "geometry.fill",
                      "stylers": [
                          {
                              "color": "#ffffff"
                          },
                          {
                              "lightness": 17
                          }
                      ]
                  },
                  {
                      "featureType": "road.highway",
                      "elementType": "geometry.stroke",
                      "stylers": [
                          {
                              "color": "#ffffff"
                          },
                          {
                              "lightness": 29
                          },
                          {
                              "weight": 0.2
                          }
                      ]
                  },
                  {
                      "featureType": "road.arterial",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#ffffff"
                          },
                          {
                              "lightness": 18
                          }
                      ]
                  },
                  {
                      "featureType": "road.local",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#ffffff"
                          },
                          {
                              "lightness": 16
                          }
                      ]
                  },
                  {
                      "featureType": "poi",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#f5f5f5"
                          },
                          {
                              "lightness": 21
                          }
                      ]
                  },
                  {
                      "featureType": "poi.park",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#dedede"
                          },
                          {
                              "lightness": 21
                          }
                      ]
                  },
                  {
                      "elementType": "labels.text.stroke",
                      "stylers": [
                          {
                              "visibility": "on"
                          },
                          {
                              "color": "#ffffff"
                          },
                          {
                              "lightness": 16
                          }
                      ]
                  },
                  {
                    //   "elementType": "labels.text.fill",
                      "stylers": [
                          {
                              "saturation": 36
                          },
                          {
                              "color": "#333333"
                          },
                          {
                              "lightness": 40
                          }
                      ]
                  },
                  {
                      "elementType": "labels.icon",
                      "stylers": [
                          {
                              "visibility": "off"
                          }
                      ]
                  },
                  {
                      "featureType": "transit",
                      "elementType": "geometry",
                      "stylers": [
                          {
                              "color": "#f2f2f2"
                          },
                          {
                              "lightness": 19
                          }
                      ]
                  },
                  {
                      "featureType": "administrative",
                      "elementType": "geometry.fill",
                      "stylers": [
                          {
                              "color": "#fefefe"
                          },
                          {
                              "lightness": 20
                          }
                      ]
                  },
                  {
                      "featureType": "administrative",
                      "elementType": "geometry.stroke",
                      "stylers": [
                          {
                              "color": "#fefefe"
                          },
                          {
                              "lightness": 17
                          },
                          {
                              "weight": 1.2
                          }
                      ]
                  }
              ],
      },
      info_marker: null,
      infowindow: {
        lat: 39.9995601,
        lng: -75.1395161
      },
      infoPosition: null,
      infoContent: null,
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        },
        maxWidth: 200,
        content: null
      },
      window_open: false,
      currentMidx: null,
    };
  },
  computed: {
    google: gmapApi,
    markers() {
      return locations.map(({ label, location: { lat, lon }, name, prev }) => ({
        label: {
          text: label,
          color: '#333',
          fontWeight: 'bold',
          fontSize: '30px'
        },
        position: {
          lat,
          lng: lon
        },
        name,
        prev,
        icon: 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="#28a745" width="44" height="44" viewBox="0 0 24 24"><path d="M12 3c2.131 0 4 1.73 4 3.702 0 2.05-1.714 4.941-4 8.561-2.286-3.62-4-6.511-4-8.561 0-1.972 1.869-3.702 4-3.702zm0-2c-3.148 0-6 2.553-6 5.702 0 3.148 2.602 6.907 6 12.298 3.398-5.391 6-9.15 6-12.298 0-3.149-2.851-5.702-6-5.702zm0 8c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm8 6h-3.135c-.385.641-.798 1.309-1.232 2h3.131l.5 1h-4.264l-.344.544-.289.456h.558l.858 2h-7.488l.858-2h.479l-.289-.456-.343-.544h-2.042l-1.011-1h2.42c-.435-.691-.848-1.359-1.232-2h-3.135l-4 8h24l-4-8zm-12.794 6h-3.97l1.764-3.528 1.516 1.528h1.549l-.859 2zm8.808-2h3.75l1 2h-3.892l-.858-2z"/></svg>'
      }));
    }
  },
  watch: {},
  methods: {
    getPosition: function(marker) {
      return {
        lat: parseFloat(marker.position.lat),
        lng: parseFloat(marker.position.lng)
      }
    },
    openWindow(marker, idx) {

      //this.window_open = true;

      this.infoPosition = this.getPosition(marker);

      this.infoOptions.content = '<div id="iw" class="iw-container">'+
                              '<div class="iw-prev mb-2">'+
                                  '<img src="' + marker.prev +'" width="200" height="200" alt="">'+
                              '</div>'+
                              '<div class="iw-body">'+
                                  '<div class="iw-label">$'+
                                      marker.label.text +
                                  '</div>'+
                                  '<h4 class="iw-address">'+
                                      marker.name +
                                  '</h4>'+
                              '</div>'+
                          '</div>';

      if (this.currentMidx === idx) {
        this.window_open = !this.window_open;
      }
      else {
        this.window_open = true;
        this.currentMidx = idx;
      }
    }
  },
  mounted: function() {


  },

  created(){
            Fire.$on('showMapsDialog',(obj)=>{
                this.dialogMap=obj.dialogMap
                this.order = obj.order
                // this.loadDrugCompaies();
            })
  }
};
</script>

<style scoped>

#map {
  height: 500px;
  width: 100%;
  margin: 0 auto;
}

.list-inline-item {
  cursor: pointer;
}

</style>
