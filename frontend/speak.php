<?php
date_default_timezone_set("America/Los_Angeles");
session_start();
if ($_SESSION["logged_in_user"] === NULL || $_SESSION["logged_in_user"] === "")
{
	echo "ERROR\n";
	exit;
}
if (!file_exists("../private"))
{
	mkdir("../private", 0755);
}
if ($_POST["submit"] === "Send")
{
	$msg = [];
	$msg["login"] = $_SESSION["logged_in_user"];
	$msg["time"] = time();
	$msg["msg"] = $_POST["message"];
	if (!file_exists("../private/chat"))
	{
		file_put_contents("../private/chat", serialize([]));
	}
	$arr = unserialize(file_get_contents("../private/chat"));
	$arr[] = $msg;
	file_put_contents("../private/chat", serialize($arr));
}
?>
<html>
	<head>
		<title>Chat</title>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script>
			function updateChat() {
				$.post("chat.php", {submit: "Send", message: $("#message").text()});
			}
		</script>
	</head>
	<body>
		<form method="post">
			<input id="message" type="text" name="message">
			<input type="submit" name="submit" value="Send" onclick="updateChat()">
		</form>
	</body>
</html>
