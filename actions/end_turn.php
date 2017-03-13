<?php 
require_once 'get_game.php';

$playerID = isset($_POST['player_id']) ? intval($_POST['player_id']) : 0;
playerCheck($game, $playerID);

$game->endTurn();
saveGame($game, $gameFile);
sendOK();
?>