import dotenv from "dotenv";
dotenv.config();
export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'client',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' },
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [],
  
  

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    '@nuxtjs/dotenv'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],
  // auth: {
  //   redirect: {
  //     login: '/login',
  //     // logout: '/',
  //     // callback: '/',
  //     // home: '/'
  //   },
  //   strategies: {
  //     laravelSanctum: {
  //       provider: 'laravel/sanctum',
  //       url: 'http://localhost:8000',
  //       cookie: {
  //         name: 'XSRF-TOKEN',
  //       },
  //       endpoints: {
  //         csrf: {
  //           url: '/sanctum/csrf-cookie'
  //         },
  //         login: { url: '/login', method: 'post' },
  //         logout: { url: '/logout', method: 'post' },
  //       }
  //     }
  //   }
  // },
  auth: {
    redirect: {
          login: '/login',
          // logout: '/',
          // callback: '/',
          // home: '/'
        },
    strategies: {
      local:{
        user: {
          property: 'data'
        },
        endpoints: {
          login: {url: '/api/login', method: 'post'},
          logout: {url: '/api/logout', method: 'post'},
          user: {url: '/api/user', method: 'get'},

        }
      }
    }
  },
 
  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    baseURL: process.env.BASE_URL,
    credentials: true,
  },
  env: {
    baseURL: process.env.BASE_URL
  },



  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},

  router: {
    middleware: ['auth']
  }

  // router: {
  //   routes: [
  //     {
  //       name: 'index',
  //       path: '/category',
  //       component: 'pages/category/index.vue'
  //     },
  //     {
  //       name: 'create',
  //       path: '/category/create',
  //       component: 'pages/category/create.vue'
  //     },
  //     {
  //       name: 'edit',
  //       path: '/category/edit/:id',
  //       component: 'pages/category/edit.vue'
  //     },
    
  //   ]
   
  // }
}
