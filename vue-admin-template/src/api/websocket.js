export default {
    ws: new WebSocket("ws://"+window.location.hostname+":7017"),
    setWs: function(newWs) {
        this.ws = newWs
    }

}