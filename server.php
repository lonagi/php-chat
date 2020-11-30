<?php

define("PORT",8090);
require_once "chat.php";

$chat = new Chat();
$socket = socket_create(AF_INET,SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket,0,PORT);
socket_listen($socket);

$client_sockets = [$socket];

while(true) {
    
    $_socket = socket_accept($socket);
    $header = socket_read($_socket,40960);
    $chat->send_headers($header, $_socket,"localhost",PORT);
}

socket_close();

?>