<template>
<div>
    <H2 class="text-3xl text-center pt-8">New Teacher Info.</H2>
    <div class="flex justify-center">
        <form id="newTeacherForm" action="#" method="GET" class="m-8 w-11/12 p-4 shadow rounded-md bg-gray-100 bg-opacity-30" v-on:submit.prevent>
            <div class="flex justify-center flex-wrap">
                <div class="mx-2 up-section">
                    <div class="m-1 w-full relative">
                        <label for="chName" class=" w-full">
                            <span> Chinese Name </span>
                            <span class="text-red-600 pointer-events-none absolute top-8 right-2"> {{ formErrors.chName }} </span>
                        </label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="chName" v-model="formData.chName" required @blur="(event)=>formCheck(/^[^\W^_]+[^\W^_]$/,event)">
                    <div class="m-1">
                        <label for="enName">English Name</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="enName" v-model="formData.enName">
                </div>
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="birth">Birth</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="date" id="birth" v-model="formData.birth">
                    <div class="m-1">
                        <label for="idNumber">Identity Number</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="idNumber" v-model="formData.idNumber">
                </div>
                <div class="mx-2 up-section">
                    <div class="m-1">
                        <label for="phone">Phone</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="phone" v-model="formData.phone">
                    <div class="m-1">
                        <label for="address">Address</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="address" v-model="formData.address">
                </div>
                <div class="w-full h-2"></div>
                <imgedit ref="canvas"></imgedit>

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
            formErrors:{
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
        formCheck(regexp,event) {
            
            if(regexp.test(event.currentTarget.value)){
                console.log(event.currentTarget.id)
                switch (event.currentTarget.id ){
                    case 'chName':
                        this.formErrors.chName = "";
                        return
                }
            }else{
                switch (event.currentTarget.id){
                    case 'chName':
                        this.formErrors.chName = "最少兩個字元，不包含特殊符號";
                        event.currentTarget.focus();
                        setTimeout(() => {
                            this.formErrors.chName = "";
                        }, 1500);
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
            width: 30%;

            input,
            div {
                width: 100%;
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

@media (max-width:500px) {
    #newTeacherForm {
        div:nth-child(2) {
            button {}
        }
    }
}
</style>
