<?php

// Start the session.
session_start();

// Check if the user is logged in.
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == 0) {
  header('Location: login.php');
  exit;
}

// Get the plant owner's ID from the session.
$plantOwnerId = $_SESSION['id'];

// Connect to the database.
$db = new PDO('mysql:host=localhost;dbname=agroculture', 'root', '');

// Get the plant expert's ID.
$sql = "SELECT id FROM plant_experts WHERE is_available = 1";
$result = $db->query($sql);

if ($result !== false) {
  $plantExpertId = $result->fetchColumn();

  // Send a message to the plant expert.
  $message = 'A plant owner is requesting your assistance.';
  $socket = new SocketIO('localhost', 8080);
  $data = array(
    'sender' => 'system',
    'message' => $message,
    'plantOwnerId' => $plantOwnerId
  );

  $socket->emit('message', JSON.stringify($data));
}

?>




<!DOCTYPE html>
<html>
<head>
  <title>Chat Room</title>
  <meta charset="UTF-8">
		<title>PlantSnap</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap\js\bootstrap.min.js"></script>
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="login.css"/>
		<link rel="stylesheet" type="text/css" href="indexFooter.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="server.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="style.css">
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>

<h1>Plant Consultation Chat</h1>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="chat">

</div>

<div id="image">

</div>

<script src="socket.io.js"></script>
<script>

var chat = document.getElementById('chat');
var image = document.getElementById('image');

var plantExpert = null;
var plantOwner = null;

var socket = io();

socket.on('connect', function() {

  // When the client connects to the server, set the plant expert to null.
  plantExpert = null;

  // Listen for messages from the server.
  socket.on('message', function(data) {
    var message = JSON.parse(data);

    // If the message is from the plant expert, add it to the chat.
    if (message.sender === 'plantExpert') {
      chat.innerHTML += '<b>Plant Expert:</b> ' + message.message + '<br>';
    }

    // If the message is from the plant owner, add it to the chat and display the image.
    else if (message.sender === 'plantOwner') {
      chat.innerHTML += '<b>Plant Owner:</b> ' + message.message + '<br>';
      if (message.image) {
        image.src = message.image;
      }
    }
  });
});

// When the user clicks the submit button, send a message to the server.
document.getElementById('submit').onclick = function() {

  // Get the message from the text box.
  var message = document.getElementById('message').value;

  // Send the message to the server.
  socket.emit('message', {
    sender: 'plantOwner',
    message: message
  });
};

</script>

</body>
</html>

