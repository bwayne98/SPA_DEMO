<template>
<div>
    <H2 class="text-3xl text-center pt-8">New Teacher Info.</H2>
    <div class="flex justify-center">
        <form id="newTeacherForm" action="#" method="GET" class="mx-w-3/5 m-8 p-4 shadow rounded-md bg-gray-100 bg-opacity-30" v-on:submit.prevent >
            <div class="flex justify-center flex-wrap">
                <div class="m-2 p-4">
                    <label for="chName">Chinese Name</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="text" id="chName" v-model="formData.chName" required>
                    <br>
                    <label for="enName">English Name</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="text" id="enName" v-model="formData.enName">
                </div>
                <div class="m-2 p-4">
                    <label for="birth">Birth</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="date" id="birth" style="width: 194px; max-height: 31px;" v-model="formData.birth" >
                    <br>
                    <label for="idNumber">Identity Number</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="text" id="idNumber" v-model="formData.idNumber">

                </div>
                <div class="m-2 p-4">
                    <label for="phone">Phone</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="text" id="phone" v-model="formData.phone">
                    <br>
                    <label for="address">Address</label>
                    <br>
                    <input class="px-2 py-1 rounded-md" type="text" id="address" v-model="formData.address">
                </div>
            </div>
            <div class="flex justify-center">
                <button @click="sendFormData()" class="m-2 py-2 px-4 bg-blue-600 bg-opacity-75 rounded-md text-white shadow active:bg-blue-800">Save</button>
                <button @click="resetConfirm()" type="button" class="m-2 py-2 px-4 bg-blue-600 bg-opacity-75 rounded-md text-white shadow active:bg-blue-800">Reset</button>
            </div>
        </form>

    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            formData: {
                chName: "",
                enName: "",
                birth:"",
                idNumber:"",
                phone:"",
                address:""
            }
        }
    },

    methods: {
        sendFormData() {
            
            console.log(this.formData)
        },

        resetConfirm(){
            if (confirm("Clean Data ?") === true){
                this.formData.chName= "";
                this.formData.enName= "";
                this.formData.birth= "";
                this.formData.idNumber= "";
                this.formData.phone= "";
                this.formData.address= "";
                console.log("Yes");
                return;
            }

            console.log("No");
            return;
        }
    }

    
}
</script>