<template>
<div>
    <div id="nav-bg" class="fixed w-full h-full bg-gray-400/40 backdrop-blur-lg" @click="addShow()" :class="{ show : nav }"></div>
    <div id="nav" class="bg-gray-100 bg-opacity-40 relative z-30" :class="{ show : nav }">

        <i id="nav-control" class="bx bx-left-indent bx-lg absolute top-0 cursor-pointer" @click="addShow()"></i>
        <div id="nav-bar" class="flex justify-center text-xl shadow">
            <div id="nav-bar-detail" class="flex justify-between w-full text-center p-6 lg:px-12 pb-0 items-baseline">
                <div id="nav-bar-icon" class="block pb-0 relative">
                    <router-link to="/" tag="a"><i class="bx bxs-home text-3xl cursor-pointer"  @click="selected()"> 首頁 </i>
                    </router-link>
                </div>
                <ul id="nav-menu" class="flex" v-if="user">
                    <li class="
              relative
              px-4
              cursor-pointer
              border-solid border-t-2 border-l-2 border-transparent
            " :class="{ show: menu[0] }" @click="menuShow(index[0])">
                        師資管理
                        <ul class="
                bg-gray-100 bg-opacity-50
                absolute
                w-full
                pointer-events-none
                shadow
                rounded-b-sm
                text-black
              ">
                            <router-link :to="'/teachers'">
                                <li @click="selected()">老師名單</li>
                            </router-link>
                            <router-link :to="'/newteacher'">
                                <li @click="selected()">新增資料</li>
                            </router-link>
                        </ul>
                    </li>
                    <li class="
              relative
              px-4

              cursor-pointer
              border-solid border-t-2 border-l-2 border-transparent
            " :class="{ show: menu[1] }" @click="menuShow(index[1])">
                        學生管理
                        <ul class="
                     bg-gray-100 bg-opacity-60
                absolute
                w-full
                pointer-events-none
                shadow
                rounded-b-sm
                text-black
              ">
                            <router-link :to="'/students'">
                                <li @click="selected()">學生名單</li>
                            </router-link>
                            <router-link :to="'/newstudent'">
                                <li @click="selected()">新增資料</li>
                            </router-link>
                        </ul>
                    </li>
                    <li class="
              relative
              px-4
              cursor-pointer
              border-solid border-t-2 border-l-2 border-transparent
            " :class="{ show: menu[2] }" @click="menuShow(index[2])">
                        課程管理
                        <ul class="
                     bg-gray-100 bg-opacity-60
                absolute
                w-full
                pointer-events-none
                shadow
                rounded-b-sm
                text-black
              ">
                            <router-link :to="'/lessons'">
                                <li @click="selected()">Search</li>
                            </router-link>
                            <router-link :to="'/newteacher'">
                                <li @click="selected()">New</li>
                            </router-link>
                        </ul>
                    </li>
                </ul>
                <div>
                    <button v-if="user" id="log-out" class="px-2 flex items-center hover:text-gray-300 truncate" @click="logOut()">
                        <i class="bx bx-log-out bx-sm" style=""></i><span class="px-1 "> 登出 ( {{ user.name }} )</span>
                    </button>
                    <router-link :to="'/login'" v-else>
                        登入
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            nums: [1, 2, 3, 4],
            user: null,
            nav: false,
            menu: [false, false, false],
            index: [0, 1, 2],
            test: 0,
        };
    },

    async mounted() {
        if (localStorage.getItem('isLogged') == 'true') {
            await axios.get('/api/user').then(res => {
                this.user = res.data
            }).catch(err => {
                localStorage.setItem('isLogged', false)
                this.user = null
            })
        }

    },
    //側邊欄顯示
    methods: {
        addShow() {
            if (this.nav) {
                document.body.style.overflow = 'auto'

            } else {
                document.body.style.overflow = 'hidden'
            }
            this.nav = !this.nav;
        },
        selected(){
            document.body.style.overflow = 'auto'
            this.nav = false;
        },
        menuShow(index) {
            this.$set(this.menu, index, !this.menu[index]);
            //array不會自動偵測  要使用$set(目標array, 索引index, 欲修改的值value)
        },
        logOut() {
            axios.get('/api/user').then(res => {
                console.log(res)
            })
        }
    },

};
</script>
