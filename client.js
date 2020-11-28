function show_message(text) {
    $("#chat-response").append("<div>"+text+"</div>");
}
    var socket = new WebSocket("ws://localhost:8090/server.php");
    socket.onopen = function () {
        show_message("The connection is established");
    };

    socket.onerror = function (e) {
        show_message("ERROR " + (e.message ? e.message : ""));
    };

    socket.onclose = function () {
        show_message("Disconnect");
    };
