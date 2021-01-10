import Vue from 'vue'
import Router from 'vue-router'
import DashboardLayout from '@/layout/DashboardLayout'
import AuthLayout from '@/layout/AuthLayout'
import localforage from "localforage";

Vue.use(Router)

export const router = new Router({
  linkExactActiveClass: 'active',
  mode: 'history',
  routes: [
    {
      path: '/',
      redirect: 'profile',
      component: DashboardLayout,
      children: [
        {
          path: '/dashboard',
          name: 'dashboard',
          // route level code-splitting
          // this generates a separate chunk (about.[hash].js) for this route
          // which is lazy-loaded when the route is visited.
          component: () => import(/* webpackChunkName: "demo" */ './views/Dashboard.vue'),
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: '/profile',
          name: 'profile',
          component: () => import(/* webpackChunkName: "demo" */ './views/UserProfile.vue'),
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: '/posts',
          name: 'posts',
          component: () => import(/* webpackChunkName: "demo" */ './views/Posts/PostsList.vue'),
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: '/posts/add',
          name: 'posts-add',
          component: () => import(/* webpackChunkName: "demo" */ './views/Posts/PostsAdd.vue'),
          meta: {
            requiresAuth: true,
          }
        }
      ]
    },
    {
      path: '/',
      redirect: 'login',
      component: AuthLayout,
      children: [
        {
          path: '/login',
          name: 'login',
          component: () => import(/* webpackChunkName: "demo" */ './views/Login.vue')
        },
        {
          path: '/register',
          name: 'register',
          component: () => import(/* webpackChunkName: "demo" */ './views/Register.vue')
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  // logout
  if(to.path === '/logout'){
    localforage.removeItem('user').then(() => {
      localforage.removeItem('authUser').then(() => {
        next({name:'login'})
      })
    })
  }

  if(to.path === '/login' || to.path === '/register'){
    localforage.getItem('authUser').then((value) => {
      const authUser = value
      if(authUser){
        next({name:'dashboard'})
      } else {
        next()
      }
    })
  }

  if(to.meta.requiresAuth){
    localforage.getItem('authUser').then((value) => {
      const authUser = value
      if(authUser){
        next()
      } else {
        next({name:'login'})
      }
    })
  } else {
    next()
  }
})

export default router;
