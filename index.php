<?php
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Chat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://ex.nvg-group.com/libs/jquery/3.4.1/f.min.js"></script>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <form action="">
            <div id="chat-response">

            </div>
        </form>
        <footer>
            <script src="client.js"></script>
        </footer>
    </body>
</html>