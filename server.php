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
    $_client_sockets = $client_sockets;
    $null_ = [];
    socket_select($_client_sockets,$null_,$null_,0,10);

    if(in_array($socket,$_client_sockets)) {
        $_socket = socket_accept($socket);
        $client_sockets[] = $_socket;

        $header = socket_read($_socket,40960);
        $chat->send_headers($header, $_socket,"localhost",PORT);

        socket_getpeername($_socket, $client_ip);
        $connection = $chat->new_connection($client_ip);
        $chat->send($connection,$client_sockets);

        $_client_sockets_index = array_search($socket,$_client_sockets);
        unset($_client_sockets[$_client_sockets_index]);
    }

    }
}

socket_close();

?>