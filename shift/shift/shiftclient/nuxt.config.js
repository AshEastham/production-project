
export default {
  /*
  ** Nuxt rendering mode
  ** See https://nuxtjs.org/api/configuration-mode
  */
  mode: 'universal',
  /*
  ** Nuxt target
  ** See https://nuxtjs.org/api/configuration-target
  */
  target: 'server',
  /*
  ** Headers of the page
  ** See https://nuxtjs.org/api/configuration-head
  */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

    /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://github.com/nuxt-community/modules/tree/master/packages/bulma
    '@nuxtjs/axios',
    '@nuxtjs/bulma',
    '@nuxtjs/auth'
  ],

  auth: {
    strategies: {
      local: {
        /* wrapped in endpoints, to ensure client can take into account auth settings */
        endpoints: {
          login: {
            url: 'auth/login', 
            method: 'post',
            propertyName: 'meta.token'
          },
          user: {
            url: 'auth/me',
            method: 'get',
            propertyName: 'data'
          }
        }
      }
    }
  },

  /*
  ** Axios settings
  */
  axios: {
    baseURL: 'http://shift.test/api'
  },

  /*
  ** Global CSS
  */
  css: [
    '~assets/styles/app.scss'
  ],
  /*
  ** Plugins to load before mounting the App
  ** https://nuxtjs.org/guide/plugins
  */
  plugins: [
  ],
  /*
  ** Auto import components
  ** See https://nuxtjs.org/api/configuration-components
  */
  components: true,
  /*
  ** Nuxt.js dev-modules
  */
  buildModules: [
  ],
  /*
  ** Build configuration
  ** See https://nuxtjs.org/api/configuration-build/
  */
  build: {
    postcss: {
      preset: {
        features: {
          customProperties: false
        }
      }
    }
  },
  watchers: {
    chokidar: {
      usePolling: true,
      useFsEvents: false
    },
    webpack: {
      aggregateTimeout: 300,
      poll: 1000
    }
  }
}
