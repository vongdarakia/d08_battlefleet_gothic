<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

$game->endTurn();
saveGame($game, $gameFile);
sendOK();
?>