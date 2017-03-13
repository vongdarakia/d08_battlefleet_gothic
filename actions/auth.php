<?php
function auth($login, $passwd)
{
	$arr = unserialize(file_get_contents("../private/passwd"));
	foreach ($arr as $acc)
	{
		if ($acc["login"] === $login && $acc["passwd"] === hash("whirlpool", $passwd))
		{
			return true;
		}
	}
	return false;
}
?>