<template>
  <div id="nav" class="bg-gray-100 bg-opacity-50 relative">
    <i
      id="nav-control"
      class="bx bx-left-indent bx-lg absolute top-0 cursor-pointer"
      @click="addShow()"
    ></i>
    <div
      id="nav-bar"
      class="
        flex
        justify-center
        text-xl
        shadow
        backdrop-filter backdrop-blur-lg
      "
    >
      <div
        id="nav-bar-detail"
        class="flex justify-between w-2/3 text-center p-8 pb-0 items-baseline"
      >
        <div id="nav-bar-icon" class="pb-0 relative">
          <router-link to="/index" class="hover:text-gray-300"
            ><i class="bx bxs-home bx-md cursor-pointer"> Home </i>
          </router-link>
        </div>
        <ul id="nav-menu" class="flex justify-around">
          <li
            class="
              min-w-max
              relative
              px-2
              py-0
              cursor-pointer
              rounded-t-md
              hover:bg-gray-400 hover:text-white
            "
            style="min-width: 100px"
          >
            Teachers
            <ul
              class="
                absolute
                w-full
                opacity-0
                pointer-events-none
                shadow
                rounded-b-sm
                bg-gray-100 bg-opacity-90
                text-black
              "
            >
              <li class="hover:bg-gray-400 hover:text-white rounded-t-sm">
                <router-link :to="'/teachers'">Search</router-link>
              </li>
              <li class="hover:bg-gray-400 hover:text-white rounded-sm">
                <router-link :to="'/newteacher'">New</router-link>
              </li>
            </ul>
          </li>
          <li
            class="
              min-w-max
              relative
              px-2
              py-0
              cursor-pointer
              rounded-t-md
              hover:bg-gray-400 hover:text-white
            "
            style="min-width: 100px"
          >
            Students
            <ul
              class="
                absolute
                w-full
                opacity-0
                pointer-events-none
                shadow
                rounded-b-sm
                bg-gray-100 bg-opacity-90
                text-black
              "
            >
              <li class="hover:bg-gray-400 hover:text-white rounded-t-sm">
                <router-link :to="'/teachers'">Search</router-link>
              </li>
              <li class="hover:bg-gray-400 hover:text-white rounded-sm">
                <router-link :to="'/newteacher'">New</router-link>
              </li>
            </ul>
          </li>
          <li
            class="
              min-w-max
              relative
              px-2
              py-0
              cursor-pointer
              rounded-t-md
              hover:bg-gray-400 hover:text-white
            "
            style="min-width: 100px"
          >
            Classes
            <ul
              class="
                absolute
                w-full
                opacity-0
                pointer-events-none
                shadow
                rounded-b-sm
                bg-gray-100 bg-opacity-90
                text-black
              "
            >
              <li class="hover:bg-gray-400 hover:text-white rounded-t-sm">
                <router-link :to="'/teachers'">Search</router-link>
              </li>
              <li class="hover:bg-gray-400 hover:text-white rounded-sm">
                <router-link :to="'/newteacher'">New</router-link>
              </li>
            </ul>
          </li>
        </ul>
        <div>
          <button
            id="log-out"
            class="px-2 flex items-center hover:text-gray-300"
          >
            <i class="bx bx-log-out bx-sm" style=""></i
            ><span class="px-1"> LogOut ({{ user }})</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      nums: [1, 2, 3, 4],
      user: "",
    };
  },

  methods: {
    addShow() {
      var navbar = document.getElementById("nav");
      navbar.classList.toggle("show");
    },
  },

  // mounted() {
  //   axios.get("api/login").then((res) => {
  //     console.log(res);
  //   });
  // },
};
</script>
