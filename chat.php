<?php

class Chat {
    public function send_headers($headers_query, $_socket, $host, $port) {
        $headers = [];
        $tmp = preg_split("/\r\n/",$headers_query);

        foreach ($tmp as $t) {
            $t = rtrim($t);
            echo $t."\n\n\n";
            if(preg_match('/\A(\S+): (.*)\z/', $t, $matches))
                $headers[$matches[1]] = $matches[2];
        }

        $key = $headers['Sec-WebSocket-Key'];
        $_key = base64_encode(pack("H*",sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11")));

        $send_headers = "HTTP/1.1 101 Switching Protocols \r\nUpgrade: websocket\r\nConnection: Upgrade\r\nWebSocket-Origin: $host\r\nWebSocket-Location: ws://$host:$port/server.php\r\nSec-WebSocket-Accept:$_key\r\n\r\n";

        socket_write($_socket, $send_headers, strlen($send_headers));
    }
    public function new_connection($client_ip) {
        $message = "New client ".$client_ip;

        return $this->seal(json_encode(["message"=>$message,"type"=>"new_connection"]));
    }
    public function send($message, $clients) {
        $len = strlen($message);
        foreach ($clients as $client)
            @socket_write($client, $message, $len);
        return true;
    }
}

?>