<?php
require_once 'Ork.class.php';
require_once __DIR__ . '/../../../Weapon/HeavyAutoWeapon.class.php';

class OrkTerrorShip extends Ork {
	public static function doc() {
		return file_get_contents('./OrkTerrorShip.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Ork Terror Ship' ) {
		parent::__construct(array('length' => 1, 'width' => 5, 'hp' => 6, 'pp' => 10, 'speed' => 12, 'handle' => 4, 'weapons' => array(new HeavyAutoWeapon($this))'cost' => 500, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>