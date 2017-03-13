<?php
include("auth.php");
session_start();
if ($_POST["submit"] === "OK")
{
	if ($_POST["login"] === NULL || $_POST["login"] === "" || $_POST["passwd"] === NULL || $_POST["passwd"] === "")
	{
		echo "ERROR\n";
		exit;
	}
	if (!file_exists("../private/passwd"))
	{
		echo "ERROR\n";
		exit;
	}
	if (auth($_POST["login"], $_POST["passwd"]))
	{
		$_SESSION["logged_in_user"] = $_POST["login"];
		header("Location: ../frontend/lobby.html");
	}
	else
	{
		echo "ERROR\n";
		exit;
	}
}
else if ($_SESSION["logged_in_user"] === NULL || $_SESSION["logged_in_user"] === "")
{
	echo "ERROR\n";
	exit;
}
?>
