<?php
require_once 'Ork.class.php';
require_once __DIR__ . '/../../../Weapon/HeavyKannon.class.php';

class OrkEscort extends Ork {
	public static function doc() {
		return file_get_contents('./OrkEscort.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Dakka In Space' ) {
		parent::__construct(array('length' => 1, 'width' => 3, 'hp' => 5, 'pp' => 10, 'speed' => 15, 'handle' => 3, 'weapons' => array(new HeavyKannon()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>