<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/LightDoubleMacroTurret.class.php';

class ImperialEscort extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialEscort.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'The Divine Perseverance' ) {
		parent::__construct(array('length' => 1, 'width' => 4, 'hp' => 5, 'pp' => 10, 'speed' => 19, 'handle' => 4, 'weapons' => array(new LightDoubleMacroTurret()), 'cost' => 42, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>