<template>
<div class="text-center">
    <h1 class="text-3xl pb-4 mt-12 font-bold">學生名單</h1>
    <div class="grid grid-cols-12">
        <div class="lg:col-start-5 lg:col-span-4 grid grid-cols-6 gap-2 col-start-4 col-span-6 ">
            <input type="text" v-model="text" placeholder="請輸入手機號碼" class="px-2 py-1 rounded-sm outline-gray-600/40 lg:col-span-4 col-span-6 focus:shadow-lg text-gray-600" @keyup.enter="studentSearch()">
            <button @click="studentSearch()" class="text-md bg-gray-600 bg-opacity-60 px-2 py-1 rounded-sm text-white hover:shadow-lg col-span-3 lg:col-span-1 disabled:opacity-50" :disabled="searching"> 查詢</button>
            <button @click="cleanSearch()" class="text-md bg-gray-600 bg-opacity-60 px-2 py-1 rounded-sm text-white hover:shadow-lg col-span-3 lg:col-span-1 disabled:opacity-50" :disabled="searching"> 清空</button>
        </div>
    </div>
    <div v-if="loading" class="m-4 text-2xl">
        <i class='bx bx-loader bx-spin'></i> Loading...
    </div>
    <div v-else id="teachersTable" class="flex justify-center mt-4">
        <div v-if="!findStudents.length" @click="cleanSearch()" class="cursor-pointer text-lg hover:text-cyan-700 mt-12">--無符合條件--</div>
        <div v-else class="shadow rounded-lg lg:w-3/6 md:w-4/5 w-full py-2">
            <div class="divide-gray-300 w-full">
                    <div class="grid grid-cols-8 py-1 text-lg font-semibold">
                        <div class=""> # </div>
                        <div class="md:col-span-4 col-span-3"> 姓名 </div>
                        <div class="md:col-span-2 col-span-2"> 連絡電話 </div>
                        <div class="md:col-span-1 col-span-2"> 詳情 </div>
                    </div>
                    <hr>
                    <div v-for="(s , index) in studentList" :key="'student' + index" class="hover:bg-gray-100 bg-opacity-70 grid grid-cols-8 rounded-md items-center" :class="{'bg-gray-200': index%2==1}">
                        <div v-if="s.id" class="py-2 "> {{(curPage-1) * perpageItem + index + 1}} </div>
                        <div v-else class="py-2 ">#</div>
                        <div v-if="s.id" class="py-2 text-left md:col-span-4 col-span-3"> {{s.chName}} ( {{s.enName}} ) </div>
                        <div v-else class="py-2 md:col-span-4 col-span-3"></div>
                        <div class="py-2 md:col-span-2 col-span-2"> {{s.phone}} </div>
                        <div v-if="s.id" class="py-2 md:col-span-1 col-span-2">
                            <router-link :to="{ name: 'student', params:{id: s.id}}" class="hover:ring-gray-400 ring-2 ring-gray-300 px-2 py-1 rounded-sm active:opacity-60">click</router-link>
                        </div>
                        <div v-else class="py-2 md:col-span-1 col-span-2"></div>
                    </div>


            </div>

        </div>

    </div>
    <div v-if="!loading" class="mt-6">
        <button v-if="curPage >= 4" @click="changePage(0)" class="mx-1 px-1 border-2 rounded-md text-gray-400"> 01 </button>
        <span v-if="curPage >= 4"><i class='bx bx-chevrons-left'></i></span>
        <button v-for="(btn,index) in totalPage" :key="'pagebtn' + index" @click="changePage(index)" :disabled="curPage == index+1" class="pagebtn mx-1 px-1 border-2 rounded-md text-gray-400 disabled:bg-gray-600 disabled:text-white" :class="{hide : curPage-index > 3 | index-curPage > 1 }">
            <span v-if="index < 9">0</span>{{ index + 1 }}
        </button>
        <span v-if="totalPage - curPage >= 3 "><i class='bx bx-chevrons-right'></i></span>
        <button v-if="totalPage - curPage >= 3" @click="changePage(totalPage-1)" class="mx-1 px-1 border-2 rounded-md text-gray-400"> <span v-if="totalPage < 9">0</span>{{ totalPage }} </button>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            students: [],
            findStudents: [],
            studentList: [],
            text: "",
            loading: true,
            searching: false,
            perpageItem: 8,
            totalPage: 0,
            curPage: 1
        }
    },
    methods: {
        studentSearch() {
            this.searching = true;

            if (this.text == "") {
                this.findStudents = this.students
                this.setPage();
                setTimeout(() => {
                    this.searching = false;
                }, 500);

                return
            }
            let reg = /^(09)[0-9]{1,7}[0-9]$/;
            if (reg.test(this.text)) {
                this.loading = true;

                let num = this.text.length;
                this.findStudents = this.students.filter((student) => {
                    return student.phone.slice(0, num) == this.text
                })

                if (this.findStudents.length > this.perpageItem) {
                    this.setPage();
                } else {
                    this.studentList = this.findStudents;
                    this.totalPage = 0;
                    this.lastItemNum = 0;
                    this.curPage = 1
                }

                setTimeout(() => {
                    this.loading = false;
                }, 500);

            } else {
                alert("請輸入手機號碼")
            }

            setTimeout(() => {
                this.searching = false;
            }, 300);

        },
        cleanSearch() {
            this.text = "";
            this.studentSearch();
        },
        setPage() {
            this.totalPage = Math.ceil(this.findStudents.length / this.perpageItem);
            this.studentList = this.findStudents.slice(0, this.perpageItem);
            document.querySelector('.pagebtn').click();
        },
        changePage(num) {
            let start = num * this.perpageItem
            let end = num * this.perpageItem + this.perpageItem
            if (end > this.findStudents.length) {
                this.studentList = this.findStudents.slice(start);
                let length = this.studentList.length
                for (let i = 0; i < this.perpageItem - length; i += 1) {
                    this.studentList.push({})
                }
            } else {
                this.studentList = this.findStudents.slice(start, end);
            }
            this.curPage = num + 1
        }
    },
    mounted() {
        this.loading = true;

        axios.get('/api/student').then(response => {
            //console.log(response.data);
            this.students = response.data;
            this.findStudents = this.students;
            if (this.findStudents.length > this.perpageItem) {
                this.totalPage = Math.ceil(this.findStudents.length / this.perpageItem);
                this.studentList = this.findStudents.slice(0, this.perpageItem);
            }else{
                this.studentList = response.data
            }
        }, ).then(()=>
        {
            setTimeout(() => {
            this.loading = false;D
        }, 500);
        });
        
    },

}
</script>

<style scoped>
button.hide {
    display: none;
}
</style>
