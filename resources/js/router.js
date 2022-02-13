import Vue from "vue";
import VueRouter from "vue-router";

// 引用頁面的 Component
import ExampleComponent from "./components/ExampleComponent.vue";
import newTeacher from "./components/newTeacher.vue";
import Teachers from "./components/Teachers.vue";
import students from "./components/students.vue";
import lessons from "./components/lessons.vue";
import studentShow from "./components/studentShow.vue";
import nav from "./components/navComponent.vue";
import login from "./components/login.vue";
import newuser from "./components/newuser.vue";
import newstudent from "./components/newStudent.vue";
import axios from "axios";

// 使用 Vue Router
Vue.use(VueRouter);

let meg = "請登入使用者"

// Route 設定
export const routes = [
    {
        path: "/newteacher",
        components: {
            default: newTeacher,
            nav: nav,
        },
        name: "newteacher",
    },
    {
        path: "/newstudent",
        components: {
            default: newstudent,
            nav: nav,
        },
        name: "newstudent",
    },

    {
        path: "/teachers",
        components: {
            default: Teachers,
            nav: nav,
        },
        name: "teachers",
    },
    {
        path: "/students",
        components: {
            default: students,
            nav: nav,
        },
        name: "students",
    },
    {
        path: "/student/:id",
        components: {
            default: studentShow,
            nav: nav,
        },
        name: "student",
    },
    {
        path: "/lessons",
        components: {
            default: lessons,
            nav: nav,
        },
        name: "lessons",
    },

    { path: "/newuser", component: newuser, name: "newuser" },
    { path: "/login" , props:{meg:meg}, component: login, name: "login" },

    {
        path: "/",
        components: {
            default: ExampleComponent,
            nav: nav,
        },
        name: "index",
    },
    { path: "*", redirect: "/" },
];

// 建立 Vue Router instance
const router = new VueRouter({
    mode: "history",
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.name != "login" && to.name != "index") {
        if (
            localStorage.getItem("isLogged") == "false" ||
            localStorage.getItem("isLogged") == null
        ) {
            meg = "請先登入"
            next({ path: "/login" });    
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
