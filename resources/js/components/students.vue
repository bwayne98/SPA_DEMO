<template>
<div class="text-center">
    <h1 class="text-3xl pb-4 mt-12 font-bold">學生名單</h1>
    <div class="grid grid-cols-12">
        <div class="lg:col-start-5 lg:col-span-4 grid grid-cols-6 gap-2 col-start-4 col-span-6 ">
            <input type="text" v-model="text" placeholder="請輸入手機號碼" class="px-2 py-1 rounded-sm outline-gray-600/40 lg:col-span-4 col-span-6 focus:shadow-lg text-gray-600"  @keyup.enter="studentSearch()">
            <button @click="studentSearch()" class="text-md bg-gray-600 bg-opacity-60 px-2 py-1 rounded-sm text-white hover:shadow-lg col-span-3 lg:col-span-1 disabled:opacity-50" :disabled="searching"> 查詢</button>
            <button @click="cleanSearch()" class="text-md bg-gray-600 bg-opacity-60 px-2 py-1 rounded-sm text-white hover:shadow-lg col-span-3 lg:col-span-1 disabled:opacity-50" :disabled="searching"> 清空</button>
        </div>
    </div>
    <div v-if="loading" class="m-4 text-2xl">
        <i class='bx bx-loader-circle bx-spin'></i> Loading...
    </div>
    <div v-else id="teachersTable" class="flex justify-center m-5">
        <div v-if="!findStudents.length" @click="cleanSearch()" class="cursor-pointer text-lg hover:text-cyan-700">--無符合條件--</div>
        <div v-else class="flex justify-center shadow p-4 rounded-xl">
            <table class="divide-y divide-gray-300">
                <thead class="">
                    <tr>
                        <th class=""> # </th>
                        <th class=""> 姓名 </th>
                        <th class=""> 連絡電話 </th>
                        <th class=""> 詳情 </th>
                    </tr>
                </thead>
                <tbody class="rounded-md">
                    <tr v-for="(s , index) in findStudents" :key="'student' + s.id" class="hover:bg-gray-100 ">
                        <td class="py-2 px-4"> {{index + 1}} </td>
                        <td class="py-2 px-4 text-left"> {{s.chName}} ({{s.enName}}) </td>
                        <td class="py-2 px-4"> {{s.phone}} </td>
                        <td class="py-2 px-4">
                            <router-link :to="{ name: 'student', params:{id: s.id}}" class="hover:ring-gray-400 ring-2 ring-gray-300 px-2 py-1 rounded-sm active:opacity-60">click</router-link>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            students: null,
            findStudents: null,
            text: "",
            loading: true,
            searching: false
        }
    },
    methods: {
        studentSearch() {
            this.searching = true;

            if (this.text == "") {
                this.findStudents = this.students
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

                setTimeout(() => {
                    this.loading = false;
                }, 500);

            } else {
                alert("請輸入手機號碼")
            }

            setTimeout(() => {
                    this.searching = false;
                }, 500);

        },
        cleanSearch() {
            this.text = "";
            this.studentSearch();
        }
    },
    mounted() {
        this.loading = true;

        axios.get('/api/student').then(response => {
            //console.log(response.data);
            this.students = response.data;
            this.findStudents = response.data;
        });

        setTimeout(() => {
            this.loading = false;
        }, 500);
    },

}
</script>
