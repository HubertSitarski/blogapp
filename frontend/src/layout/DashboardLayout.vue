<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <side-bar
      :background-color="sidebarBackground"
      short-title="Argon"
      title="Argon"
    >
      <template slot="links">
        <sidebar-item :link="{name: 'Profil', icon: 'ni ni-single-02 text-yellow', path: '/profile'}"/>
        <sidebar-item v-if="loggedUser && loggedUser.role == 'Super Admin'" :link="{name: 'Wpisy', icon: 'ni ni-single-copy-04 text-green', path: '/posts'}"/>
        <sidebar-item :link="{name: 'Wyloguj', icon: 'ni ni-user-run text-info', path: '/logout'}"/>
      </template>
    </side-bar>
    <div class="main-content" :data="sidebarBackground">
      <dashboard-navbar></dashboard-navbar>

      <div @click="toggleSidebar">
        <fade-transition :duration="200" origin="center top" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </fade-transition>
        <content-footer v-if="!$route.meta.hideFooter"></content-footer>
      </div>
    </div>
  </div>
</template>
<script>
  import DashboardNavbar from './DashboardNavbar.vue';
  import ContentFooter from './ContentFooter.vue';
  import { FadeTransition } from 'vue2-transitions';
  import localforage from "localforage";

  export default {
    components: {
      DashboardNavbar,
      ContentFooter,
      FadeTransition
    },
    data() {
      return {
        loggedUser: null,
        sidebarBackground: 'vue' //vue|blue|orange|green|red|primary
      };
    },
    methods: {
      toggleSidebar() {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false);
        }
      }
    },
    created() {
      localforage.getItem('user').then((data) => {
        if (data) {
          this.loggedUser = data
          this.$store.dispatch('fetchUser', { id: data.id })
        }
      })
    }
  };
</script>
<style lang="scss">
</style>
