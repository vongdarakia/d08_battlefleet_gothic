<?php
session_start();
if (!file_exists("../private/passwd"))
{
	echo "ERROR\n";
	exit;
}
$arr = unserialize(file_get_contents("../private/passwd"));
if ($_GET["user"] !== NULL) {
	foreach ($arr as &$acc)
	{
		if ($acc["login"] === $_GET["user"])
		{
			echo <<<EOT
Username: {$acc["login"]}<br>
Rating: {$acc["rating"]}<br>
Wins: {$acc["wins"]}<br>
Losses: {$acc["loss"]}<br>
EOT;
			exit;
		}
	}
	echo "ERROR\n";
}
else if ($_SESSION["logged_in_user"] !== NULL) {
	foreach ($arr as &$acc)
	{
		if ($acc["login"] === $_SESSION["logged_in_user"])
		{
			echo <<<EOT
Username: {$acc["login"]}<br>
Rating: {$acc["rating"]}<br>
Wins: {$acc["wins"]}<br>
Losses: {$acc["loss"]}<br>
EOT;
			exit;
		}
	}
	echo "ERROR\n";
}
else {
	echo "ERROR\n";
}
?>