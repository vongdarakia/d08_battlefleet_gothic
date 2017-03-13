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
		<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
	</head>
	<body>
		<form action="speak.php" method="post">
			<input type="text" name="message">
			<input type="submit" name="submit" value="Send">
		</form>
	</body>
</html>
