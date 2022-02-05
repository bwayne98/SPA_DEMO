<template>
<div id="nav" class="bg-gray-100 bg-opacity-40 relative z-20" :class="{ show: nav }">
    <i id="nav-control" class="bx bx-left-indent bx-lg absolute top-0 cursor-pointer" @click="addShow()"></i>
    <div id="nav-bar" class="flex justify-center text-xl shadow backdrop-blur-lg">
        <div id="nav-bar-detail" class="flex justify-between w-2/3 text-center p-8 pb-0 items-baseline">
            <div id="nav-bar-icon" class="block pb-0 relative">
                <router-link to="/" tag="a"><i class="bx bxs-home text-3xl cursor-pointer"> 首頁 </i>
                </router-link>
            </div>
            <ul id="nav-menu" class="flex">
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
                        <router-link :to="'/teachers'" >
                            <li @click="addShow()" >老師名單</li>
                        </router-link>
                        <router-link :to="'/newteacher'">
                            <li @click="addShow()">新增資料</li>
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
                            <li @click="addShow()">學生名單</li>
                        </router-link>
                        <router-link :to="'/newstudent'">
                            <li @click="addShow()">新增資料</li>
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
                        <router-link :to="'/teachers'">
                            <li @click="addShow()">Search</li>
                        </router-link>
                        <router-link :to="'/newteacher'">
                            <li @click="addShow()">New</li>
                        </router-link>
                    </ul>
                </li>
            </ul>
            <div>
                <button id="log-out" class="px-2 flex items-center hover:text-gray-300">
                    <i class="bx bx-log-out bx-sm" style=""></i><span class="px-1"> 登出 ( {{ user }} )</span>
                </button>
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
            user: "0",
            nav: false,
            menu: [false, false, false],
            index: [0, 1, 2],
            test: 0,
        };
    },

    //側邊欄顯示
    methods: {
        addShow() {
            this.nav = !this.nav;
            this.$set(this.menu, 0, false);
            this.$set(this.menu, 1, false);
            this.$set(this.menu, 2, false);
        },
        menuShow(index) {
            this.$set(this.menu, index, !this.menu[index]);
            //array不會自動偵測  要使用$set(目標array, 索引index, 欲修改的值value)
        },
    },

    //獲取登入資訊
    // async mounted() {
    //   await axios.get("login").then((res) => {
    //     console.log(res);
    //     this.user = res.data;
    //   });
    // },
};
</script>
