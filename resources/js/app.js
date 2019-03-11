
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import VueFusionCharts from 'vue-fusioncharts';
import FusionCharts from 'fusioncharts';
import AngularGauge from 'fusioncharts/fusioncharts.widgets';
import FusionTheme from 'fusioncharts/themes/fusioncharts.theme.fusion';
import ZuneTheme from 'fusioncharts/themes/fusioncharts.theme.zune';

import JsonExcel from 'vue-json-excel'

Vue.component('downloadExcel', JsonExcel)

Vue.use(VueFusionCharts, FusionCharts, AngularGauge, FusionTheme, ZuneTheme);

Vue.use(ElementUI);

Vue.use(BootstrapVue)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('branch-page', require('./components/BranchPage.vue').default);
Vue.component('company-page', require('./components/CompanyPage.vue').default);
Vue.component('reports-page', require('./components/ReportsPage.vue').default);
Vue.component('report-page', require('./components/ReportPage.vue').default);
Vue.component('barchart-component', require('./components/BarChartComponent.vue').default);

Vue.component('admin-users-page', require('./components/AdminUsersPage.vue').default);
Vue.component('admin-user-page', require('./components/AdminUserPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
