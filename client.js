function show_message(text) {
    $("#chat-response").append("<div>"+text+"</div>");
}
    var socket = new WebSocket("ws://localhost:8090/server.php");
