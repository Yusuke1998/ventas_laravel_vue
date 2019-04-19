require('./bootstrap');

window.Vue = require('vue');

Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('articulo', require('./components/Articulo.vue'));

const app = new Vue({
    el: '#app',
    data : {
    	// menu : 0
    	menu : 2
    }
});
