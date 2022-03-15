<template>
<div class="
      flex flex-col flex-nowrap
      justify-center
      w-screen
      h-screen
      items-center
      bg-gray-100
    ">
    <div class="text-center" v-if="loginStatus">
        <h1 class="text-xl m-5 font-light">
            Success ! Return to the home page.
        </h1>
        <!-- <a href="/index" class="hover:text-pink-400 underline">Retrun to Home</a> -->
    </div>

    <div v-else id="login" class="w-96 shadow rounded-xl text-center p-5 pb-0">
        <h1 class="my-5 text-4xl font-bold">Login</h1>
        <p>Lorem ipsum dolor sit amet.</p>
        <p class="text-red-600">{{ meg }}</p>
        <div class="p-5 px-12">
            <form action="" v-on:submit.prevent>
                <div>
                    <div class="text-left left-2 mx-1">
                        <label for="email">Account</label>
                    </div>
                    <input type="text" name="email" id="account" class="my-2 px-2 py-1 rounded-md w-60" v-model="form.email" />
                    <div class="text-left left-2 mx-1">
                        <label for="password" class="text-left">Password</label>
                    </div>
                    <input type="password" name="" id="password" autocomplete="on" class="my-2 px-2 py-1 rounded-md w-60" v-model="form.password" />
                </div>
                <div class="p-3 pb-0">
                    <button @click.prevent="setLogin()" class="bg-blue-300 mt-2 px-2 py-1 rounded-xl hover:bg-blue-200">
                        Submit
                    </button>
                    <router-link to="/newuser" class="mx-2 hover:text-pink-400">
                        Register
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            loginStatus: false,
            meg: '',
        };
    },

    mounted() {
        if (localStorage.getItem("isLogged") == 'true') {
            this.loginStatus = true
            setTimeout(() => {
                this.$router.push('/')
            }, 2000);
        }
        console.log(this.register);
    },

    methods: {
        setLogin() {
            this.meg = '';
            axios.get('/sanctum/csrf-cookie').then(res => {
                axios.post("api/login", this.form).then((res) => {
                    console.log(res);
                    this.loginStatus = true;

                    localStorage.setItem('isLogged', true)

                    setTimeout(() => {
                        this.$router.push('/')
                    }, 2000);

                }).catch(err => {
                    this.meg='帳號或密碼錯誤!';
                });
            });

        },
    },
}
</script>
