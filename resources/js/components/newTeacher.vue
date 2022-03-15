<template>
<div>
    <H2 class="text-3xl text-center pt-8">New Teacher Info.</H2>
    <div class="flex justify-center">
        <form id="newTeacherForm" action="#" method="GET" class="m-8 w-11/12 p-4 shadow rounded-md bg-gray-100 bg-opacity-30" v-on:submit.prevent>
            <div class="flex justify-center flex-wrap">
                <div class="mx-2 up-section">
                    <div class="m-1 w-full relative">
                        <label for="chName" class="flex flex-col xs:flex-row items-baseline">
                            <div class="pr-4"> 中文姓名 </div>
                            <div class="text-red-600 pointer-events-none pr-2" v-show="formErrors.chName !== ''"><i class='bx bx-message-rounded-error text-xs pt-1 sm:text-base'> {{ formErrors.chName }}</i></div>
                        </label>
                    </div>
                    <input class="px-2 py-1 rounded-md ring-1 ring-transparent" :class="{ 'ring-red-600': formErrors.chName !== ''}" type="text" id="chName" v-model="formData.chName" required @blur="(event)=>formCheck(/^[\u4e00-\u9fa5]+[\u4e00-\u9fa5]$/,event)">
                    <div class="m-1">
                        <label for="enName" class="flex flex-col xs:flex-row items-baseline">
                            <div class="pr-4"> 英文姓名 </div>
                            <div class="text-red-600 pointer-events-none pr-2" v-show="formErrors.enName !== ''"><i class='bx bx-message-rounded-error text-xs pt-1 sm:text-base'> {{ formErrors.enName }}</i></div>
                        </label>
                    </div>
                    <input class="px-2 py-1 rounded-md ring-1 ring-transparent" :class="{ 'ring-red-600': formErrors.enName !== ''}" type="text" id="enName" v-model="formData.enName" required @blur="(event)=>formCheck(/^[A-Z][a-z]{3,}$/,event)">
                    <div class="m-1">
                        <label for="birth" >生日</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="date" id="birth" v-model="formData.birth" required>
                </div>
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="idNumber" class="flex flex-col xs:flex-row items-baseline">
                            <div class="pr-4" > 身分證字號 </div>
                            <div class="text-red-600 pointer-events-none pr-2" v-show="formErrors.idNumber !== ''"> <i class='bx bx-message-rounded-error text-xs pt-1 sm:text-base'> {{ formErrors.idNumber }}</i></div>
                        </label>
                    </div>
                    <input class="px-2 py-1 rounded-md ring-1 ring-transparent" :class="{ 'ring-red-600': formErrors.idNumber !== ''}" type="text" id="idNumber" v-model="formData.idNumber" required @blur="(event)=>formCheck(/^[A-Z][1,2][0-9]{8}$/,event)">
                    <div class="m-1">
                        <label for="phone" class="flex flex-col xs:flex-row items-baseline">
                            <div class="pr-4"> 手機號碼 </div>
                            <div class="text-red-600 pointer-events-none pr-2" v-show="formErrors.phone !== ''"> <i class='bx bx-message-rounded-error text-xs pt-1 sm:text-base'> {{ formErrors.phone }}</i></div>
                        </label>
                    </div>
                    <input class="px-2 py-1 rounded-md ring-1 ring-transparent" :class="{ 'ring-red-600': formErrors.phone !== ''}" type="text" id="phone" v-model="formData.phone" required @blur="(event)=>formCheck(/^09[0-9]{8}$/,event)">
                    <div class="m-1">
                        <label for="address">通訊地址</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="address" v-model="formData.address" required>
                </div>
                <div class="w-full h-2">

                </div>
                <div class="w-full">
                    <div class="text-center text-xl font-medium cursor-pointer" @click="canvasLoad()">
                        上傳照片
                    </div>
                    <div>
                        <imgedit ref="canvas"></imgedit>
                    </div>
                </div>

            </div>
            <div class="grid sm:grid-cols-3 mx-6 my-4 gap-4 grid-rows-3 sm:grid-rows-1">
                <button @click="canvasLoad()" type="button" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white"><span>載入圖片</span></button>
                <button @click="sendFormData()" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white">Save</button>
                <button @click="resetConfirm()" type="button" class="py-2 px-4 bg-cyan-600/80 rounded-md text-white">Reset</button>
            </div>
        </form>

    </div>
</div>
</template>

<script>
import imgedit from './imgEdit.vue';

export default {
    components: {
        'imgedit': imgedit
    },
    data() {
        return {
            formData: {
                chName: "",
                enName: "",
                birth: "",
                idNumber: "",
                phone: "",
                address: "",
            },
            formErrors: {
                chName: "",
                enName: "",
                birth: "",
                idNumber: "",
                phone: "",
                address: "",
            },
            canvas_size: 1000,
        }
    },
    methods: {
        sendFormData() {
            console.log(this.formData)
        },

        resetConfirm() {
            if (confirm("Clean Data ?") === true) {
                this.formData.chName = "";
                this.formData.enName = "";
                this.formData.birth = "";
                this.formData.idNumber = "";
                this.formData.phone = "";
                this.formData.address = "";
                return;
            }
            return;
        },
        canvasLoad() {
            this.$refs.canvas.loadImg();
            this.img_onload = true;
        },
        formCheck(regexp, event) {

            if (regexp.test(event.currentTarget.value)) {
                console.log(event.currentTarget.id)
                switch (event.currentTarget.id) {
                    case 'chName':
                        this.formErrors.chName = "";
                        return
                    case 'enName':
                        this.formErrors.enName = ""
                        return
                    case 'idNumber':
                        this.formErrors.idNumber = ""
                        return
                    case 'phone':
                        this.formErrors.phone = ""
                        return
                }
            } else {
                switch (event.currentTarget.id) {
                    case 'chName':
                        this.formErrors.chName = "最少兩個中文字元";
                        return
                    case 'enName':
                        this.formErrors.enName = "字首大寫，最少四個英文字元"
                        return
                    case 'idNumber':
                        this.formErrors.idNumber = "字首英文大寫"
                        return
                    case 'phone':
                        this.formErrors.phone = "09開頭十位數字"
                        return
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped>
#newTeacherForm {
    div {
        button {
            box-shadow: 1px 2px black, 3px 5px black;
            border-style: solid;
            border-width: 0 1px 1px 0;
            border-color: transparent;
        }

        button:hover {
            border-color: white;
        }

        button:active {
            color: black;
        }

        div.up-section {
            width: 48%;

            input,
            div {
                width: 100%;

                label {
                    div {
                        width: auto;
                    }
                }
            }
        }

        // div:nth-child(4) {
        //     width: 30%;
        //     input{
        //         width: 100px;
        //     }
        // }
    }
}

@media (max-width:1024px) {
    #newTeacherForm {
        div {

            div.up-section {
                width: 90%
            }
        }
    }
}
</style>
