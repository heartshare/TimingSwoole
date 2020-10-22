import Vue from 'vue'

import 'normalize.css/normalize.css' // A modern alternative to CSS resets

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en' // lang i18n

import '@/styles/index.scss' // global css

import App from './App'
import store from './store'
import router from './router'

import '@/icons' // icon
import '@/permission' // permission control


import axios from 'axios';

import global from './api/websocket.js'
Vue.prototype.$global = global
// global.ws = new WebSocket("ws://localhost:7017");


			global.ws.onopen = function()
               {
                  // Web Socket 已连接上，使用 send() 方法发送数据
                  // ws.send("发送数据");
                  console.log('-------')
                  console.log(returnCitySN["cip"])
                  console.log('-------')

                  console.log(returnCitySN["cip"])
               };       
            global.ws.onclose = function()
                { 
                    // 关闭 websocket
                    alert("连接已关闭...")
                    console.log("连接已关闭..."); 
                };

/**
 * If you don't want to use mock-server
 * you want to use MockJs for mock api
 * you can execute: mockXHR()
 *
 * Currently MockJs will be used in the production environment,
 * please remove it before going online ! ! !
 */
if (process.env.NODE_ENV === 'production') {
  const { mockXHR } = require('../mock')
  mockXHR()
}

// set ElementUI lang to EN
Vue.use(ElementUI, { locale })
// 如果想要中文版 element-ui，按如下方式声明
// Vue.use(ElementUI)

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
