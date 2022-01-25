import Vue from 'vue';
import VueRouter from 'vue-router';

// 引用頁面的 Component
import ExampleComponent from './components/ExampleComponent.vue';
import newTeacher from "./components/newTeacher.vue";
import Teachers from "./components/Teachers.vue";
import students from "./components/students.vue";
import studentShow from "./components/studentShow.vue";
import nav from "./components/navComponent.vue";
import login from "./components/login.vue";
import newuser from "./components/newuser.vue";

// 使用 Vue Router
Vue.use(VueRouter);

// Route 設定
export const routes = [
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
{   path: '/students', 
    components: {
        default: students,
        nav: nav,
    }, 
    name:'students'
},
{   path: '/student/:id', 
    components: {
        default: studentShow,
        nav: nav,
    }, 
    name:'student'
},

{   path: '/newuser', 
    component: newuser,
    name: "newuser"
},
{   path: '/auth/login', 
    component: login,
    name: "login"
},

{   path: '/', 
    components: {
        default: ExampleComponent,
        nav: nav,
    },
    name:'index'
},
// {   path: '*', 
//     redirect: "/index"
// },

];

// 建立 Vue Router instance
const router = new VueRouter({
  mode: 'history',
  routes
});

export default router;