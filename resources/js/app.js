require('./bootstrap');

require('alpinejs');
window.Vue = require('vue');
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

import { App, plugin } from '@inertiajs/inertia-vue'

import Vuetify from 'vuetify'

Vue.use(Vuetify,{

    theme: {
        themes: {
            light: {
                primary: '#3f51b5',
                secondary: '#b0bec5',
                accent: '#8c9eff',
                error: '#b71c1c',
              },
            dark: {
                error: '#b71c1c',
              //here you will define primary secondary stuff for dark theme
            }
        },
        dark: false
    }


})

require('bootstrap-table/dist/bootstrap-table')

require('tableexport.jquery.plugin')
require('bootstrap-table/dist/extensions/export/bootstrap-table-export')
require('bootstrap-table/dist/extensions/print/bootstrap-table-print')

require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control')

import DataTable from '@andresouzaabreu/vue-data-table'
Vue.component("data-table", DataTable)

Vue.use(plugin)


import {Form ,HasError,AlertError} from 'vform';
import moment from "moment";

import Swal from 'sweetalert2'

window.Swal=Swal

import Gate from "./Gate";
Vue.prototype.$gate=new Gate(window.user)


/// import restoran components
import ProductsGrid from 'vue-products-grid'

////   Vue Printer
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
    name: '_blank',
    specs: [
      'fullscreen=yes',
      'titlebar=yes',
      'scrollbars=yes'
    ],
    styles: [
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
        "https://unpkg.com/kidlat-css/css/kidlat.css",
      '/css/admin.css',
      '/css/Print.css'
    ]
  }
Vue.use(VueHtmlToPaper, options);
////    Vue Printer

window.Fire=new Vue()





const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast=Toast


window.Form=Form;
Vue.component(HasError.name,HasError)
Vue.component(AlertError.name,AlertError)


import VueRouter from 'vue-router'
import routes from './routes'
Vue.use(VueRouter)
/// progress bar vue
import vueProgressBar from 'vue-progressbar'
Vue.use(vueProgressBar,{
    color:'rgb(143,255,199)',
    failedColor:'red',
    hieght:'3px'
})

const router=new VueRouter({
    // base: '/discount/public/',
    mode:'history',
    routes
})


/// Passport Client Components /////
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);



Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1)
    //text.toUpperCase();
})

Vue.filter('activeText',function(active){
    return active ? 'مفعل ' : 'غير مفعل '
    //text.toUpperCase();
})


Vue.filter('statusText',function(status){
    console.log(status);
    return status <= 0 ? 'جديد' : 'تم التسليم '
    //text.toUpperCase();
})


Vue.filter('myDate',function(date){
    return moment(date).format("MMMMM Do YYYY")
    //text.toUpperCase();
})

Vue.component('pagination',require('laravel-vue-pagination'))

Vue.component('not-found',require('./components/NotFount').default)


/// Map Import

import * as VueGoogleMaps from 'vue2-google-maps'


Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyCw1U4k3SUNLzXHGP2-zp_BZGyiBuhPuDs",
      libraries: "places", // necessary for places input
      region: "uk,en"
    }
  });

// TODO Mapbox-lg Importing

require('mapbox-gl')
// import * as mapboxgl from 'mapbox-gl'

//   Vue.use(mapboxgl)


  // TODO //Json To Excel Packege
  import JsonExcel from "vue-json-excel";
  Vue.component("downloadExcel", JsonExcel);





  /// TODO Bootstrap-vue

  import { BootstrapVue } from 'bootstrap-vue'
  Vue.use(BootstrapVue)

const app = new Vue({
    el: '#app',
    // vuetify,
    vuetify: new Vuetify({
        theme: {
            themes: {
                light: {
                    primary: '#3f51b5',
                    secondary: '#b0bec5',
                    accent: '#8c9eff',
                    error: '#b71c1c',
                    red: '#FF0000',

                  },
                dark: {
                    error: '#b71c1c',
                  //here you will define primary secondary stuff for dark theme
                }
            },
            dark: false
        },
        icons: {
            iconfont: 'mdi',
          },
          rtl: true,
        }),
    router,
    data:{
        search:''
    },
    methods:{
        searchit:_.debounce(()=>{ // to wait evry 1 second then send request
            Fire.$emit("Searching")
        },1000),

        printPDF(){
            window.print()
        }
    }

});
