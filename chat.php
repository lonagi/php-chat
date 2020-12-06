<?php

class Chat {
    public function send_headers($headers_query, $_socket, $host, $port) {
        $headers = [];
        $tmp = preg_split("/\r\n/",$headers_query);

        foreach ($tmp as $t) {
            $t = rtrim($t);
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

    public function seal($socket_data) {
        $b1 = 0x81;
        $b2 = strlen($socket_data);
        $h = "";

        if($b2 <= 125)
            $h = pack("CC", $b1, $b2);
        else if($b2 > 125 && $b2 < 65536)
            $h = pack("CCn", $b1, 126, $b2);
        else
            $h = pack("CCNN", $b1, 127, $b2);
        return $h.$socket_data;
    }

    public function unseal($socket_data) {
        $len = ord($socket_data[1]) & 127;
        if($len == 126) {
            $mask = substr($socket_data,4,4);
            $data = substr($socket_data,8);
        }
        else if($len == 127) {
            $mask = substr($socket_data,10,4);
            $data = substr($socket_data,14);
        }
        else {
            $mask = substr($socket_data,2,4);
            $data = substr($socket_data,6);
        }

        $socket_str = "";
        for($i=0;$i<strlen($data);++$i)
            $socket_str .= $data[$i] ^ $mask[$i%4];
        return $socket_str;
    }

    public function send($message, $clients) {
        $len = strlen($message);
        foreach ($clients as $client)
            @socket_write($client, $message, $len);
        return true;
    }
}

?>