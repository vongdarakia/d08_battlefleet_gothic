<?php 
require_once 'game_save.php';

// Need to require these so that these classes can get rendered for the game object.
require_once __DIR__ . '/../classes/Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../classes/Battlefleet/Object.class.php';
require_once __DIR__ . '/../classes/Battlefleet/Player.class.php';
require_once __DIR__ . '/../classes/Spaceship/Spaceship.class.php';
require_once __DIR__ . '/../classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
require_once __DIR__ . '/../classes/Weapon/NauticalLance.class.php';
require_once __DIR__ . '/../classes/Weapon/Weapon.class.php';

$gameFile = "../private/game";
$game = loadGame($gameFile);
?>