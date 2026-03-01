<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omegle Style Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .navbar {
            background: #1e293b;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
            color: #38bdf8;
            letter-spacing: 1px;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        .logout-btn {
            background: transparent;
            color: #ef4444;
            border: 1px solid #ef4444;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background: #ef4444;
            color: white;
        }

        /* Main Omegle Chat Area */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
            padding: 20px;
        }

        .chat-status {
            color: #94a3b8;
            font-style: italic;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .chat-box {
            flex: 1;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Message Styling (Omegle Format) */
        .msg {
            font-size: 16px;
            line-height: 1.4;
            word-wrap: break-word;
        }
        .msg .sender {
            font-weight: bold;
            margin-right: 5px;
        }
        .msg.stranger .sender {
            color: #f87171; /* Red for stranger/friend */
        }
        .msg.you .sender {
            color: #38bdf8; /* Blue for you */
        }
        .msg.system {
            color: #fbbf24;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        /* Footer Controls */
        .chat-controls {
            display: flex;
            gap: 10px;
            height: 50px;
        }
        .btn {
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
            padding: 0 20px;
        }
        .btn-stop {
            background: #ef4444;
            color: white;
            min-width: 100px;
        }
        .btn-stop:hover {
            background: #dc2626;
        }
        .btn-send {
            background: #38bdf8;
            color: #0f172a;
            min-width: 100px;
        }
        .btn-send:hover {
            background: #0ea5e9;
        }
        .chat-input {
            flex: 1;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            outline: none;
        }
        .chat-input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="navbar-brand">AnonChat</div>
        <div class="user-profile">
            <span>Ashish</span>
            <button class="logout-btn">Logout</button>
        </div>
    </div>

    <div class="chat-container">

        <div class="chat-status" id="chatStatus">
            Looking for someone you can chat with...
        </div>

        <div class="chat-box" id="chatBody">
            <div class="msg system">You're now chatting with a random stranger. Say hi!</div>
            <div class="msg stranger"><span class="sender">Stranger:</span> hello</div>
            <div class="msg you"><span class="sender">You:</span> hey, kya haal hai?</div>
        </div>

        <div class="chat-controls">
            <button class="btn btn-stop" id="btnDisconnect" onclick="disconnectChat()">Stop</button>
            <input type="text" class="chat-input" id="messageInput" placeholder="Type your message..." autocomplete="off">
            <button class="btn btn-send" onclick="sendMessage()">Send</button>
        </div>

    </div>

<script>
    // Laravel CSRF setup for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let receiver_id = null; // Set this dynamically when a match is found

    // Enter key press to send message
    $('#messageInput').keypress(function(e){
        if(e.which == 13) {
            sendMessage();
            return false;
        }
    });

    function sendMessage() {
        let inputField = $("#messageInput");
        let message = inputField.val().trim();

        if(message === "") return;

        // Immediately append "You:" message to UI for fast UX
        $("#chatBody").append(`
            <div class="msg you"><span class="sender">You:</span> ${message}</div>
        `);

        // Auto-scroll to bottom
        scrollToBottom();

        // Clear input
        inputField.val('');

        // Uncomment aapke backend logic ke liye
        /*
        $.post('/send-message', {
            receiver_id: receiver_id,
            message: message
        }, function(response){
            // Handle success if needed
        });
        */
    }

    function disconnectChat() {
        let btn = $("#btnDisconnect");

        if(btn.text() === "Stop") {
            // Confirm disconnect logically
            $("#chatBody").append('<div class="msg system">You have disconnected.</div>');
            btn.text("Really?");
            $("#messageInput").prop('disabled', true);
        } else {
            // "Next" logic
            $("#chatBody").html('<div class="msg system">Connecting to server...</div>');
            btn.text("Stop");
            $("#messageInput").prop('disabled', false);
            // Yahan aap apna AJAX call kar sakte ho naya banda dhundhne ke liye
        }
        scrollToBottom();
    }

    function scrollToBottom() {
        let chatBox = document.getElementById("chatBody");
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>

</body>
</html>
