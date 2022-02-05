<template>
<div class="grid grid-cols-4 mt-12">
    <div class=" lg:col-start-2 col-start-2 col-span-2 text-center mb-4">
        <div class="text-3xl font-bold">學生基本資料</div>
        <div class="m-2 flex justify-center text-cyan-500" v-if="success.status">
            <i class='bx bx-cloud-upload text-xl pt-1 pr-2'></i>
            <span class='leading-7'> {{success.meg}} 學生資料已新增</span>
        </div>
    </div>
    <form class=" lg:col-start-2 col-start-2 lg:grid lg:grid-cols-2 col-span-2" action="#" method="POST">
        <div class="grid p-2">
            <label for="" class="border-b-2 mb-1">中文姓名
                <span v-if="errors.chineseName" class="text-sm text-red-800"> <i class='bx bx-message-rounded-error'></i>最少兩個字元</span>
            </label>
            <input class="px-2 py-1 rounded-sm focus:outline-cyan-600/40 w-full" type="text" placeholder="請填入中文姓名，例：王大明" v-model="student.chineseName">
        </div>
        <div class="grid p-2">
            <label for="" class="border-b-2 mb-1">英文姓名
                <span v-if="errors.englishName" class="text-sm text-red-800"> <i class='bx bx-message-rounded-error'></i>最少三個字元</span>
            </label>
            <input class="px-2 py-1 rounded-sm focus:outline-cyan-600/40 w-full" type="text" placeholder="請填入英文姓名，例：Paul" v-model="student.englishName">
        </div>
        <div class="grid p-2">
            <label for="" class="border-b-2 mb-1 self-end">生日
                <span v-if="errors.birth" class="text-sm text-red-800"> <i class='bx bx-message-rounded-error'></i>請再確認日期</span>
            </label>

            <input class="px-1 py-1 rounded-sm focus:outline-cyan-600/40 w-full" type="date" placeholder="請填入生日，例：2022/01/01" v-model="student.birth">
        </div>
        <div class="grid p-2">
            <label for="" class="border-b-2 mb-1">聯絡電話
                <span v-if="errors.phone" class="text-sm text-red-800"> <i class='bx bx-message-rounded-error'></i>號碼為十個字元</span>
            </label>
            <input class="px-2 py-1 rounded-sm focus:outline-cyan-600/40 w-full" type="text" placeholder="請填入手機號碼，例：0912111222" v-model="student.phone">
        </div>
        <div class="grid p-2 lg:col-span-2">
            <label for="" class="border-b-2 mb-1">通訊地址
                <span v-if="errors.address" class="text-sm text-red-800"> <i class='bx bx-message-rounded-error'></i>最少十個字元</span>
            </label>
            <input class="px-2 py-1 rounded-sm focus:outline-cyan-600/40 w-full" type="text" placeholder="請填入地址，例：雲林縣斗六市雲林路二段515號" v-model="student.address">
        </div>
        <div class="grid lg:grid-cols-2 grid-rows-2 p-2 lg:col-span-2 gap-2 mt-2">
            <button type="button" class="bg-cyan-600 bg-opacity-80 rounded-sm text-white border-2 border-cyan-800 border-opacity-0 hover:border-opacity-80 disabled:opacity-50" @click="sentForm()" :disabled="checking">送出</button>
            <button type="button" class="bg-rose-400 bg-opacity-80 rounded-sm text-white border-2 border-rose-800 border-opacity-0 hover:border-opacity-80 disabled:opacity-50" @click="cleanForm()" :disabled="checking">清空</button>
        </div>

    </form>
</div>
</template>

<script>
export default {
    data() {
        return {
            student: {
                chineseName: "",
                englishName: "",
                birth: "2000-01-01",
                phone: "",
                address: ""
            },
            errors: {
                chineseName: "",
                englishName: "",
                birth: "",
                phone: "",
                address: ""
            },
            error: false,
            success: {
                status: false,
                meg: ""
            },
            checking: false
        }
    },
    methods: {

        async sentForm() {
            this.success.status = false;
            this.checking = true;
            this.errors = {
                chineseName: "",
                englishName: "",
                birth: "",
                phone: "",
                address: ""
            };

            let check = confirm("確定送出資料?");

            if (check) {
                await axios.post("/api/student", this.student).then(res => {
                    if (res.status == 204) {
                        this.success.status = true;
                        this.success.meg = this.student.chineseName;
                        this.student = {
                            chineseName: "",
                            englishName: "",
                            birth: "2000-01-01",
                            phone: "",
                            address: ""
                        }
                    }
                }).catch(err => {
                    this.errors = err.response.data.errors
                })
            }

            setTimeout(() => {
                this.checking = false;
            }, 500);

        },

        cleanForm() {
            let check = confirm("確定清空表格?");
            if (check) {
                this.student = {
                    chineseName: "",
                    englishName: "",
                    birth: "2000-01-01",
                    phone: "",
                    address: ""
                };
                this.errors = {
                    chineseName: "",
                    englishName: "",
                    birth: "",
                    phone: "",
                    address: ""
                }
                this.success = {
                    status: false,
                    meg: ""
                }

            }
        }
    }

}
</script>

<style scoped>
/* input::-webkit-input-placeholder {
    font-size: 14px;
    line-height: 3;
} */

.error {
    background-color: red;
}
</style>
