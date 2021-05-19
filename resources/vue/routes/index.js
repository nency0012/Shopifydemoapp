import Vue from 'vue'
import  VueRouter from  'vue-router'



Vue.use(VueRouter);

import Master from "../layouts/Master";
import  Orders from './../pages/Orders/Index.vue';
//import demo from './../pages/Orders/demo.vue';
import  Customers from './../pages/Customers/Index.vue';
//import Nav from "../core/Nav.vue";


const routes = [
   // { path:'/', component:Orders},
   // { path: '/demo', component:demo}
    {
        path: '/',
        component: Master,
        children: [
            {
                path: 'order',
                component: Orders,
                name: 'app.orders',
                meta: {
                    title: 'Orders',
                  //  requiresAuth: true
                }
            },
            {
                path: 'customer',
                component: Customers,
                name: 'app.customers',
                meta: {
                    title: 'Customers',
                    //  requiresAuth: true
                }
            },

        ]
    } ];


const  router = new VueRouter({

     mode: 'history',
    routes,
});

export default router;
