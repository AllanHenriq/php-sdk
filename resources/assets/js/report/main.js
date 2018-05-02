var Vue = require('vue')
var VueResource = require('vue-resource')

Vue.use(VueResource)
var CardViewer = require('./components/CardViewer.vue')

new Vue({
  el: '#app',

  render: function () {
  },

  ready() {
    alert('Combo drawn, ready to rock!')
  }
})
