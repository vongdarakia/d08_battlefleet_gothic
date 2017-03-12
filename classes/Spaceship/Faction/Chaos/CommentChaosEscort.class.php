<?php
require_once 'Chaos.class.php';
require_once __DIR__ . '/../../../Weapon/LightMissilePod.class.php';

class ChaosEscort extends Chaos {
	public static function doc() {
		return file_get_contents('./ChaosEscort.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'The Scream of Ecstasy' ) {
		parent::__construct(array('length' => 1, 'width' => 3, 'hp' => 4, 'pp' => 10, 'speed' => 18, 'handle' => 3, 'weapons' => array(new LightMissilePod()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>