<template>
  <div
    class="
      flex flex-col flex-nowrap
      justify-center
      w-screen
      h-screen
      items-center
      bg-gray-100
    "
  >
    <div class="text-center" v-if="register">
      <h1 class="text-xl m-5 font-light">
        {{ register }} is now registed, Please Login !
      </h1>
      <!-- <a href="/index" class="hover:text-pink-400 underline">Retrun to Home</a> -->
    </div>

    <div id="login" class="w-96 shadow rounded-xl text-center p-5 pb-0">
      <h1 class="my-5 text-4xl font-bold">Login</h1>
      <p>Lorem ipsum dolor sit amet.</p>
      <div class="p-5 px-12">
        <form action="" v-on:submit.prevent>
          <div>
            <div class="text-left left-2 mx-1">
              <label for="account">Account</label>
            </div>
            <input
              type="text"
              name="account"
              id="account"
              class="my-2 px-2 py-1 rounded-md w-60"
              v-model="form.account"
            />
            <div class="text-left left-2 mx-1">
              <label for="password" class="text-left">Password</label>
            </div>
            <input
              type="password"
              name=""
              id="password"
              autocomplete="on"
              class="my-2 px-2 py-1 rounded-md w-60"
              v-model="form.password"
            />
          </div>
          <div class="p-3 pb-0">
            <button
              @click="getLogin()"
              class="bg-blue-300 mt-2 px-2 py-1 rounded-xl hover:bg-blue-200"
            >
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
  props: ["register"],
  data() {
    return {
      form: {
        account: "",
        password: "",
      },
      dataBase: {
        account: "abc",
        password: "123",
      },
    };
  },

  mounted() {
    if (sessionStorage.getItem("Login")) {
      this.login = true;
    }
    console.log(this.register);
  },

  methods: {
    getLogin() {
      axios.post("api/login", this.form).then((res) => {
        if (res) {
          this.$router.push("/index");
        } else {
          console.log("error");
        }
      });
    },
  },
};
</script>
