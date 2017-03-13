<?php
if (!file_exists("../private/passwd"))
{
	echo "ERROR\n";
	exit;
}
$arr = unserialize(file_get_contents("../private/passwd"));
function cmp($a, $b) {
	return $b["rating"] - $a["rating"];
}
usort($arr, "cmp");
?>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
	<body>

		<table style="width:100%">
			<tr>
				<th>Rank</th>
				<th>Username</th>
				<th>Rating</th>
				<th>Wins</th>
				<th>Losses</th>
			</tr>
			<?php
				$rank = 1;
				foreach ($arr as $acc) {
					echo <<<EOT
			<tr>
				<th>{$rank}</th>
				<th>{$acc["login"]}</th>
				<th>{$acc["rating"]}</th>
				<th>{$acc["wins"]}</th>
				<th>{$acc["loss"]}</th>
			</tr>
EOT;
					$rank++;
				}
			?>
		</table>

	</body>
</html>
