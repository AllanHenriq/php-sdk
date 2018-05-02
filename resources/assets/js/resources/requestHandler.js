// CSRF TOKEN
var VueResource = require('vue-resource')
var Vue = require('vue')
Vue.use(VueResource)

var standardOptions = {
  /*headers: {
    'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('content')
}*/
}

export default {
  get: function (endpoint, params) {
    return Vue.http.get(endpoint, { params: params }, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  post: function (endpoint, params, options) {
    return Vue.http.post(endpoint, params, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  put: function (endpoint, params) {
    return Vue.http.put(endpoint, params, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  patch: function (endpoint, params) {
    return Vue.http.patch(endpoint, params, standardOptions)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  delete: function (endpoint, params) {
    var options
    if (params) {
      options = {
        params: params,
        headers: { 'X-CSRF-TOKEN': standardOptions.headers['X-CSRF-TOKEN'] }
      }
    } else {
      options = standardOptions
    }
    return Vue.http.delete(endpoint, options)
        .then((response) => {
          return response.data
        }, (error) => {
          return this.handleError(error)
        })
  },
  handleError: function (error) {
    return {
      error: true,
      code: error.status,
      message: error.body
    }
  }
}
