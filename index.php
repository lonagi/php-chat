<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Chat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://ex.nvg-group.com/libs/jquery/3.4.1/f.min.js"></script>
        <style>
            #chat-response {
                display: inline-block;
                background: aliceblue;
                padding: 20px;
                font-size: 18px;
                color: black;
                border: 1px solid #9c9c9c;
                width: 500px;
                min-height: 200px;
                overflow-y: scroll;
                -ms-overflow-y: scroll;
            }
        </style>
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