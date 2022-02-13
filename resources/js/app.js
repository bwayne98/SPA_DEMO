
require('./bootstrap');


window.Vue = require('vue').default;
import router from './router';

import index from './index'
import axios from 'axios';

const app = new Vue({
    el: '#app',
    router,

    components: {
        "index": index
    },

    async created(){
        // await axios.get('/sanctum/csrf-cookie').then(res=>{
        //     console.log(res);
        // });
        // await axios.post('/login',{
        //     email:"destin.wuckert@example.org",
        //     password:"password"
        // })
        // .then(res=>{
        //     axios.get('/user');
        // })
        // .catch(err=>{
        //     console.log(err);
        // })
    },
});
