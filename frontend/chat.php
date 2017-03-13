<?php
date_default_timezone_set("America/Los_Angeles");
session_start();
if ($_SESSION["logged_in_user"] === NULL || $_SESSION["logged_in_user"] === "")
{
	echo "ERROR\n";
	exit;
}
if (!file_exists("../private/chat"))
{
	exit;
}
$arr = unserialize(file_get_contents("../private/chat"));
foreach ($arr as $msg)
{
	echo date("[H:i]", $msg["time"]);
	echo " <b>{$msg['login']}</b>: {$msg['msg']}<br />\n";
}
?>