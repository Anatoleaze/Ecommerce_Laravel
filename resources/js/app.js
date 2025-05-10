/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from 'axios';
import { createApp } from 'vue';
import store from './store/store.js ';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import SliderComponent from './components/home/SliderComponent.vue';
import CategoryCartComponent from './components/CategoryCartComponent.vue';
import FilterComponent from './components/products/FilterComponent.vue';
import ContactFormComponent from './components/contact/ContactFormComponent.vue';
import ProfilUpdateComponent from './components/user/ProfilUpdateComponent.vue';
import ProfilComponent from './components/user/ProfilComponent.vue';
import Create_Product_Component from './components/products/Create_Product_Component.vue';
import HeaderComponent from './components/header/HeaderComponent.vue';
import CartComponent from './components/products/CartComponent.vue';
import OrderComponent from './components/orders/OrderComponent.vue';
import OrderDetailsComponent from './components/orders/OrderDetailsComponent.vue';  
import PaymentModal from './components/orders/PaymentModal.vue';

app.component('slider-component', SliderComponent);
app.component('category-cart-component', CategoryCartComponent);
app.component('filter-component', FilterComponent);
app.component('contact-form-component', ContactFormComponent);
app.component('profil-update-component', ProfilUpdateComponent);
app.component('profil-component', ProfilComponent);
app.component('create-product-component',Create_Product_Component);
app.component('header-component', HeaderComponent);
app.component('cart-component', CartComponent);
app.component('order-component', OrderComponent);
app.component('order-details-component', OrderDetailsComponent);
app.component('payment-modal', PaymentModal);

app.use(store);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.mount('#app');
