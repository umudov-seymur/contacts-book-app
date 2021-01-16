<template>
  <div class="min-h-screen bg-white">
    <div class="flex">
      <div
        class="sidebar bg-gray-200 h-screen border-r-2 w-48 pl-6 border-gray-400"
      >
        <Sidebar />
      </div>
      <div class="flex flex-col flex-1 overflow-y-hidden h-screen">
        <div
          class="h-16 px-6 border-b border-gray-400 flex items-center justify-between bg-blue-500"
        >
          <span class="font-bold uppercase text-white">{{ title }}</span>
          <div class="flex items-center space-x-4">
            <SearchBar />
            <UserCircle :name="user.name" />
          </div>
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto h-screen">
          <transition mode="out-in" name="fade">
            <router-view class="p-6" />
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
import SearchBar from "./SearchBar.vue";
import UserCircle from "./UserCircle.vue";

export default {
  components: {
    Sidebar,
    SearchBar,
    UserCircle,
  },
  data() {
    return {
      title: "",
    };
  },
  created() {
    this.title = this.$route.meta.title;
  },
  computed: {
    user() {
      return window.user_data;
    },
  },
  methods: {
    setToken() {
      window.axios.defaults.headers.common[
        "Authorization"
      ] = `Bearer ${this.user.api_token}`;
    },
  },
  watch: {
    $route(to, from) {
      this.setToken();
      this.title = to.meta.title;
    },

    title() {
      document.title = this.title + " | The SPA App";
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.2s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>
