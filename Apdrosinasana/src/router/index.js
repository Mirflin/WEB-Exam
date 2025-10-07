import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Home/HomeView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Auth/Signin.vue'),
      meta: {
        guest: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Auth/Signup.vue'),
      meta: {
        guest: true
      }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/Dashboard/Dashboard.vue'),
      meta: {
        requireAuth: true
      }
    },
  ],

  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      const element = document.querySelector(to.hash)
      if (element) {
        const top = element.getBoundingClientRect().top + window.pageYOffset
        const offset = 150
        return window.scrollTo({
          top: top - offset,
          behavior: 'smooth',
        })
      }
    } else if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  },
})

router.beforeEach(async (to , from, next) => {
  const auth = useAuthStore()

  if(!auth.isAuthResolved){
    await auth.attempt()
  }

  if(to.meta.requireAuth && !auth.authenticated){
    next('/login')
  }else if(to.meta.guest && auth.authenticated){
    next('/dashboard')
  }
  else{
    next()
  }

})

export default router
