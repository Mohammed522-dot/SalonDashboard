
let routes=[
    {path:'/dashboard',component:require('./components/Dashboard.vue').default},
    {path:'/users',component:require('./components/user/users.vue').default},
    {path:'/profile',component:require('./components/user/Profile.vue').default},
    {path: '/medicinesections',component:require('./components/Department/index.vue').default},
    {path: '/categories',component:require('./components/Category/index.vue').default},
    {path: '/subcategories',component:require('./components/SubCategory/index.vue').default},
    {path: '/companies',component:require('./components/Company/index.vue').default},
    {path: '/offers',component:require('./components/Offer/index.vue').default},
    {path: '/products',component:require('./components/Product/index.vue').default},
    {path: '/services',component:require('./components/Service/index.vue').default},
    {path: '/reporting',component:require('./components/Order/index.vue').default},
    {path: '/maps/:id',component:require('./components/MyCustomMaps/MyMapBoxVue.vue').default,props:true},
    {path: '/pharmaceuticalforms',component:require('./components/pharmaceuticalforms/index.vue').default},
    {path: '/nameScinces',component:require('./components/NameScinces/index.vue').default},


    {path: '/booking',component:require('./components/Offer/Order/index.vue').default},
    // {path: '/reporting',component:require('./components/Reportings').default},
    {path: '/developer',component:require('./components/developers.vue').default},






];


export default routes;
