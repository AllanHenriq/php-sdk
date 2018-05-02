import Request from '../resources/requestHandler.js'

export default {
  show: function (params) {
    return Request.get('/api/card', params)
  }
}
