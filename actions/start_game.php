<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');

// Need to require these so that these classes can get rendered for the game object.
require_once __DIR__ . '/../classes/Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../classes/Battlefleet/Object.class.php';
require_once __DIR__ . '/../classes/Battlefleet/Player.class.php';
require_once __DIR__ . '/../classes/Spaceship/Spaceship.class.php';
require_once __DIR__ . '/../classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
require_once __DIR__ . '/../classes/Weapon/NauticalLance.class.php';
require_once __DIR__ . '/../classes/Weapon/Weapon.class.php';
require_once 'game_save.php';

$bf = new Battlefleet();	
saveGame($bf, '../private/game');
header("Content-Type: application/json");
echo json_encode($bf);
?>