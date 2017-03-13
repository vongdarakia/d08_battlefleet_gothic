<?php
include("auth.php");
if ($_POST["submit"] === "OK")
{
	if ($_POST["login"] === NULL || $_POST["login"] === "" || $_POST["oldpw"] === NULL || $_POST["oldpw"] === "" || $_POST["newpw"] === NULL || $_POST["newpw"] === "")
	{
		echo "ERROR\n";
		exit;
	}
	if (!file_exists("../private/passwd"))
	{
		echo "ERROR\n";
		exit;
	}
	if (auth($_POST["login"], $_POST["oldpw"]))
	{
		$arr = unserialize(file_get_contents("../private/passwd"));
		foreach ($arr as &$acc)
		{
			if ($acc["login"] === $_POST["login"])
			{
				$acc["passwd"] = hash("whirlpool", $_POST["newpw"]);
			}
		}
		file_put_contents("../private/passwd", serialize($arr));
		header("Location: index.html");
		echo "OK\n";
	}
	else
	{
		echo "ERROR\n";
	}
}
else
{
	echo "ERROR\n";
}
?>