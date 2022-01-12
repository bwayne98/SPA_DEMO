
require('./bootstrap');


window.Vue = require('vue').default;
import router from './router';

import index from './index'

const app = new Vue({
    el: '#app',
    router,
    data(){
        return {
            rooo: 0
        }
    },
    components: {
        "index": index
    }
});
