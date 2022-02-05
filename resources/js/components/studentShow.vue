<template>
<div class="grid grid-cols-10 my-16 mx-4">
    <!-- 確認跳窗 -->
    <transition>
        <div v-if="!loading && check" class="inset-0 flex fixed w-full h-screen justify-center items-center bg-gray-900 z-30 bg-opacity-60">
            <div class="w-80 h-80 bg-white rounded-md relative">
                <div class="w-full text-center text-3xl pt-3 pb-2 bg-slate-300 rounded-t-md font-bold text-red-600">
                    <i class='bx bxs-error'></i> 最後確認</div>
                <h1 class="m-2 text-lg font-bold">即將修改為以下資訊? </h1>
                <div class="mx-2 grid grid-cols-4 gap-y-1 text-md">
                    <div>中文姓名 |</div>
                    <div class="col-span-3">{{student.chName}}</div>
                    <div>英文姓名 |</div>
                    <div class="col-span-3">{{student.enName}}</div>
                    <div>聯絡電話 |</div>
                    <div class="col-span-3">{{student.phone}}</div>
                    <div>通訊地址 |</div>
                    <div class="col-span-3">{{student.address}}</div>
                </div>

                <div class="w-full bottom-0 absolute grid grid-cols-2">
                    <button class="py-2 bg-green-600 text-white bg-opacity-80 rounded-bl-md active:bg-opacity-100" @click="updateStudent()">確認</button>
                    <button class="py-2 bg-rose-600 text-white bg-opacity-80 rounded-br-md active:bg-opacity-100" @click="finalCheck()">返回</button>
                </div>
            </div>
        </div>
    </transition>
    <!-- 主要內容 -->
    <div class="lg:col-span-2 col-span-1"></div>
    <div v-if="loading" class="text-xl lg:col-span-6 col-span-8 font-bold h-48 items-center flex w-full justify-center">
        <i class='bx bx-loader-circle bx-spin'></i> Loading...
    </div>
    <div v-else class="lg:col-span-6 col-span-8">
        <h1 class="text-2xl text-center font-bold">學生資訊</h1>
        <div v-if="errors" class="text-center text-rose-700 text-opacity-70 mt-1"> <i class='bx bx-x-circle'></i> 資料格式錯誤，請再確認 </div>
        <div v-if="updated" class="text-center text-cyan-700 text-opacity-80 mt-1"> <i class='bx bx-cloud-upload text-lg'></i> 學生資料已更新 </div>
        <hr class="my-2" />

        <div class="grid grid-cols-6 gap-y-2 gap-x-4">
            <div class="
            col-span-6
            gap-2
            grid
            lg:grid-rows-2 lg:col-span-1 lg:grid-cols-1 lg:divide-x-0
            grid-cols-4
            items-center
          ">
                <div class="
              text-lg
              font-semibold
              border-r-2 border-cyan-700 border-opacity-20
              lg:border-0
            ">
                    中文姓名
                </div>
                <div class="col-span-3" v-if="edit">
                    <input type="text" v-model="student.chName" class="w-full px-2 py-1 rounded" />
                </div>
                <div v-else class="col-span-3 lg:col-span-1 lg:place-self-start">{{student.chName}}</div>
            </div>
            <div class="
            grid
            lg:grid-rows-2 lg:col-span-1 lg:grid-cols-1
            col-span-6
            grid-cols-4
            gap-2
            items-center
          ">
                <div class="
              text-lg
              font-semibold
              border-r-2 border-cyan-700 border-opacity-20
              lg:border-0
            ">
                    英文姓名
                </div>
                <div class="col-span-3" v-if="edit">
                    <input type="text" v-model="student.enName" class="w-full px-2 py-1 rounded" />
                </div>
                <div class="col-span-3 lg:place-self-start" v-else>
                    {{ student.enName }}
                </div>
            </div>
            <div class="grid lg:grid-rows-2 lg:col-span-1 lg:grid-cols-1 col-span-6 grid-cols-4 gap-2 items-center">
                <div class="text-lg font-semibold border-r-2 border-cyan-700 border-opacity-20 lg:border-0">
                    聯絡電話
                </div>
                <div class="col-span-3" v-if="edit">
                    <input type="text" v-model="student.phone" class="w-full px-2 py-1 rounded" />
                </div>
                <div class="col-span-3 lg:place-self-start" v-else>
                    {{ student.phone }}
                </div>
            </div>
            <div class="grid lg:col-span-3 lg:grid-rows-2 lg:grid-cols-1 col-span-6 grid-cols-4 gap-2 items-center">
                <div class="text-lg font-semibold border-r-2 border-cyan-700 border-opacity-20 lg:border-0">
                    通訊地址
                </div>
                <div class="col-span-3" v-if="edit">
                    <input type="text" v-model="student.address" class="w-full px-2 py-1 rounded" />
                </div>
                <div class="col-span-3 lg:place-self-start" v-else>
                    {{ student.address }}
                </div>
            </div>
        </div>
        <div class="mt-4 p-2 text-right border-b-2 border-gray-700 border-opacity-50">
            <!-- 編輯按鈕 -->
            <button class="
            disabled:opacity-50
            active:ring-1
            w-24
            ring-gray-400
            bg-gray-300 bg-opacity-50
            rounded
            m-1
          " :disabled="!button" v-if="edit" @click="finalCheck()">
                修改
            </button>
            <button class="
            disabled:opacity-50
            active:ring-1
            w-24
            ring-gray-400
            bg-gray-300 bg-opacity-50
            rounded
            m-1
          " @click="reset()" :disabled="!button" v-if="edit">
                取消
            </button>
            <button class="
            disabled:opacity-50
            active:ring-1
            w-24
            ring-gray-400
            bg-gray-300 bg-opacity-50
            rounded
            m-1
          " @click="editor()" :disabled="!button" v-if="!edit">
                編輯
            </button>
        </div>
    </div>
    <div class="lg:col-span-2 col-span-1"></div>
    <!-- 下半段 -->

    <!-- 標題 -->

    <div class="col-span-10 grid grid-cols-12 lg:col-start-3 lg:col-end-9 gap-y-1" v-if="!loading">
        <div class="col-span-12">
            <h1 class=" text-2xl text-center font-bold mt-20">課程資訊</h1>
            <hr class="my-2" />
        </div>

        <div class="col-span-12 grid grid-cols-12">
            <div>#</div>
            <div class="col-span-2">名稱</div>
            <div class="col-span-2">教室</div>
            <div class="col-span-3">老師</div>
            <div class="col-span-4">時段</div>
        </div>
        <!-- 清單 -->
        <div class="col-span-12 grid grid-cols-12" v-for="(lesson, index1) in lessons" :key="lesson.id">
            <div>{{ index1 + 1 }}</div>
            <div class="col-span-2">{{ lesson.name }}</div>
            <div class="col-span-2">{{ lesson.room }}</div>
            <div class="col-span-3">{{ teachers[index1].chName }}</div>
            <div class="col-span-4 justify-between flex">
                <div>{{ lesson.period }}</div>
                <div class="cursor-pointer z-10" @click="showattend(index1)" id="attendControl" :class="{ show: attendcontrol[index1]}"><i class="
                bx bx-chevron-down
                bg-cyan-700 bg-opacity-30
                rounded-sm
                z-10
              "></i></div>
            </div>
            <div class="col-span-12 m-0  p-1 overflow-hidden relative">
                <div class="grid grid-cols-6 lg:grid-cols-12 gap-1" id="attend" :class="{ show: attendcontrol[index1] }">
                    <div v-for="(date, index2) in lesson.date" :key="'lesson' + index2" class="
                border-2 border-cyan-700 border-opacity-30
                text-center
                rounded
              ">
                        <div class="text-xs md:text-sm">{{ date.slice(5) }}</div>
                        <div v-if="lessonsDetail[index1].attend[index2] == false">
                            <i class="bx bx-x-circle text-red-600"></i>
                        </div>
                        <div v-else><i class="bx bx-smile text-green-600"></i></div>
                    </div>
                </div>
            </div>
            <!-- 出席紀錄 -->
            <!-- <transition>
                <div class="col-span-12 grid grid-cols-6 lg:grid-cols-12 m-0 gap-1 p-1" v-if="attendcontrol[index1]">
                    <div v-for="(date, index2) in lesson.date" :key="'lesson' + index2" class="
                border-2 border-cyan-700 border-opacity-30
                text-center
                rounded
              ">
                        <div class="text-xs md:text-sm">{{ date.slice(5) }}</div>
                        <div v-if="lessonsDetail[index1].attend[index2] == false">
                            <i class="bx bx-x-circle text-red-600"></i>
                        </div>
                        <div v-else><i class="bx bx-smile text-green-600"></i></div>
                    </div>
                </div>
            </transition> -->
        </div>

    </div>

    <div class="text-center mt-20 col-span-10">
        <router-link to="/students" class="text-cyan-700 hover:text-opacity-30"> --返回學生清單-- </router-link>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            student: null,
            editstudent: null,
            edit: false,
            loading: true,
            lessons: null,
            teachers: null,
            button: true,
            lessonsDetail: null,
            attendcontrol: [],
            check: false,
            errors: null,
            updated: false
        };
    },
    async beforeCreate() {
        await axios.get("/api/student/" + this.$route.params.id).then((res) => {
            this.student = res.data;
            console.log(res.data);
        }).catch(() => {
            this.$router.push('/');
        });

        await axios
            .get("/api/student/" + this.$route.params.id + "/showstudentlessons")
            .then((res) => {
                console.log("showlesson : " + res.data);
                this.lessons = res.data[0];
                this.teachers = res.data[1];
                this.lessonsDetail = res.data[2];
            });

        for (var i = 0; i < this.lessonsDetail.length; i++) {
            this.attendcontrol.push(false);
        }

        this.loading = false;
    },
    methods: {
        editor() {
            this.button = false;
            this.edit = true;

            setTimeout(() => {
                this.button = true;
            }, 200);
        },
        async reset() {
            this.loading = true;
            this.button = false;
            this.errors = null;
            this.updated = false

            await axios
                .get("/api/student/" + this.$route.params.id)
                .then((res) => {
                    this.student = res.data;
                    console.log(res.data);
                })
                .then(() => {
                    this.edit = false;
                });

            setTimeout(() => {
                this.button = true;
                this.loading = false;
            }, 200);
        },
        showattend(index) {
            this.$set(this.attendcontrol, index, !this.attendcontrol[index]);
        },
        finalCheck() {
            this.check = !this.check;
            this.updated = false
        },
        async updateStudent() {
            this.loading = true;
            this.errors = null;
            this.updated = false

            await axios.put('/api/student/' + this.$route.params.id, this.student).then(res => {
                if (res.status == 204) {
                    console.log(res);
                    this.reset();
                    this.finalCheck();
                    this.updated = true;
                }

            }).catch(err => {
                this.errors = err.response.data.errors
                this.finalCheck();
                this.loading = false;
            })

        }
    },
};
</script>

<style scoped>
.v-leave {
    opacity: 1;
}

.v-leave-active {
    opacity: 0;
    transition: all 0.3s;
}

.v-leave-to {
    opacity: 0;
}

.v-enter-active {

    animation: jump 0.3s;
}

@keyframes jump {
    0% {
        transform: scale(0.8)
    }

    50% {
        transform: scale(1.08)
    }

    100% {
        transform: scale(1)
    }
}

#attendControl.show i {
    transform: rotate(180deg);
}

#attend {

    margin-top: -110px;
    transition: all 0.5s;
}

#attend.show {

    margin-top: 0px
}

@media (max-width:1024px) {
    #attend {
        margin-top: -210px;
    }
}

@media (max-width:300px) {
    #attend {
        margin-top: -260px;
    }
}
</style>
