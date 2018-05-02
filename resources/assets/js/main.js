var Vue = require('vue')
var VueResource = require('vue-resource')

Vue.use(VueResource)
var CardViewer = require('./components/CardViewer.vue')

new Vue({
  el: '#app',

  render: function (createElement) {
    return createElement(CardViewer)
  },

  ready() {
    alert('Combo drawn, ready to rock!')
  }
})
