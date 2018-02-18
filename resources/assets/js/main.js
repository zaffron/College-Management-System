require ('./bootstrap');

Vue.component('search', require('./components/SearchComponenet.vue'));

const app = new Vue({
   el: '#app'
    data: {
       searchQuery: ''
    }
    methods:{

    }
});
