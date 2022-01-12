<template>
    
    <div class="flex flex-nowrap justify-center w-screen h-screen items-center bg-gray-100">
        <div class="w-96 shadow rounded-xl text-center p-5 pb-0">
            <h1 class="my-5 text-4xl font-bold">Register</h1>
            <p>Lorem ipsum dolor sit amet.</p>
            <div class="p-5 px-12">
                <form action="" v-on:submit.prevent method="POST">
                    <div>
                        <div class="text-left left-2 mx-1">
                            <label for="account" >Account</label>
                        </div>
                        <input type="text" name="account" id="account" class="my-2 px-2 py-1 rounded-md w-60" v-model="form.account">
                        <div class="text-left left-2 mx-1">
                            <label for="password" class="text-left ">Password</label>
                        </div>
                        <input type="password" name="" id="password" autocomplete="on" class="my-2 px-2 py-1 rounded-md w-60" v-model="form.password">
                    </div>
                    <div class="p-3 pb-0">
                        <button @click="uewuser()" class=" bg-blue-300 mt-2 px-2 py-1 rounded-xl hover:bg-blue-200">Submit</button>
                        <router-link to="/login" class="mx-2 hover:text-pink-400 underline "> Login </router-link>
                    </div>

                </form>
            </div>
        </div>


    </div>


</template>

<script>
export default {
    data(){
        return {
            form:{
                account: "",
                password: ""
            },
        }
    },
    
    mounted(){
    },

    methods: {
        uewuser(){
            axios.post('/api/newuser',this.form).then(res=>{
                if(res){
                    this.$router.push({name: 'login', params:{register: "abc"}})
                }
            }).catch(error=>{
                console.log(error);
            })
        }
    }

    
}
</script>