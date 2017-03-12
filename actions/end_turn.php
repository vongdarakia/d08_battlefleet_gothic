<?php 
require_once 'get_game.php';
// $player_id = $_POST["player_id"];
$game->endTurn();
saveGame($game, $gameFile);
?>