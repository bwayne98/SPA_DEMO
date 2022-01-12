import Vue from 'vue';
import VueRouter from 'vue-router';

// 引用頁面的 Component
import ExampleComponent from './components/ExampleComponent.vue';
import newTeacher from "./components/newTeacher.vue";
import Teachers from "./components/Teachers.vue";
import nav from "./components/navComponent.vue";
import login from "./components/login.vue";
import newuser from "./components/newuser.vue";

// 使用 Vue Router
Vue.use(VueRouter);

// Route 設定
export const routes = [
{   path: '/index', 
    components: {
        default: ExampleComponent,
        nav: nav,
    },
    name:'index'
},

{   path: '/newteacher', 
    components: {
        default: newTeacher,
        nav: nav,
    },
    name:'newteacher'
},

{   path: '/teachers', 
    components: {
        default: Teachers,
        nav: nav,
    }, 
    name:'teachers'
},

{   path: '/newuser', 
    component: newuser,
    name: "newuser"
},
{   path: '/login', 
    component: login,
    name: "newuser"
},
{   path: '*', 
    redirect: "/index"
},

];

// 建立 Vue Router instance
const router = new VueRouter({
  mode: 'history',
  routes
});

export default router;