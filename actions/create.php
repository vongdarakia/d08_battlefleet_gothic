<?php
if ($_POST["submit"] === "OK")
{
	if ($_POST["login"] === NULL || $_POST["login"] === "" || $_POST["passwd"] === NULL || $_POST["passwd"] === "")
	{
		echo "ERROR\n";
		exit;
	}
	if (!file_exists("../private"))
	{
		mkdir("../private", 0755);
	}
	if (file_exists("../private/passwd"))
	{
		$arr = unserialize(file_get_contents("../private/passwd"));
	}
	else
	{
		$arr = [];
	}
	foreach ($arr as $acc)
	{
		if ($acc["login"] === $_POST["login"])
		{
			echo "ERROR\n";
			exit;
		}
	}
	$user = [];
	$user["login"] = $_POST["login"];
	$user["passwd"] = hash("whirlpool", $_POST["passwd"]);
	$user["rating"] = 42;
	$user["wins"] = 0;
	$user["loss"] = 0;
	$arr[] = $user;
	file_put_contents("../private/passwd", serialize($arr));
	header("Location: ../frontend/login.html");
	echo "OK\n";
}
else
{
	echo "ERROR\n";
}
?>