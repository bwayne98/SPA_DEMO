<template>
<div>
    <H2 class="text-3xl text-center pt-8">New Teacher Info.</H2>
    <div class="flex justify-center">
        <form id="newTeacherForm" action="#" method="GET" class="mx-w-3/5 m-8 p-4 shadow rounded-md bg-gray-100 bg-opacity-30" v-on:submit.prevent>
            <div class="flex justify-center flex-wrap">
                <div class="mx-2">
                    <div class="m-1">
                        <label for="chName">Chinese Name</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="chName" v-model="formData.chName" required>
                    <div class="m-1">
                        <label for="enName">English Name</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="enName" v-model="formData.enName">
                </div>
                <div class="mx-2">
                    <div class="m-1">
                        <label for="birth">Birth</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="date" id="birth" v-model="formData.birth">
                    <div class="m-1">
                        <label for="idNumber">Identity Number</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="idNumber" v-model="formData.idNumber">
                </div>
                <div class="mx-2">
                    <div class="m-1">
                        <label for="phone">Phone</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="phone" v-model="formData.phone">
                    <div class="m-1">
                        <label for="address">Address</label>
                    </div>
                    <input class="px-2 py-1 rounded-md" type="text" id="address" v-model="formData.address">
                </div>
            </div>
            <div class="flex justify-center mt-3">
                <button @click="sendFormData()" class="m-2 py-2 px-4 bg-cyan-600/80 rounded-md text-white">Save</button>
                <button @click="resetConfirm()" type="button" class="m-2 py-2 px-4 bg-cyan-600/80 rounded-md text-white">Reset</button>
            </div>
        </form>

    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            formData: {
                chName: "",
                enName: "",
                birth: "",
                idNumber: "",
                phone: "",
                address: ""
            }
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
                console.log("Yes");
                return;
            }

            console.log("No");
            return;
        }
    }

}
</script>

<style lang="sass" scoped>

#newTeacherForm
    div
        button
            width: 30%
            box-shadow: 1px 2px black, 3px 5px black
            border-style: solid
            border-width: 0 1px 1px 0
            border-color: transparent
        button:hover
            border-color: white
        button:active
            color: black
        div
            width: 30%
            input, div
                width: 100%

@media (max-width:1024px) 
    #newTeacherForm
        div
            button
                width: 40%
            div
                width: 90%


</style>
