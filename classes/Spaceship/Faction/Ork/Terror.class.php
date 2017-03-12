<?php
require_once 'Ork.class.php';
require_once __DIR__ . '/../../../Weapon/MakroKanon.class.php';

class Terror extends Ork {
	public static function doc() {
		return file_get_contents('./Terror.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Ork\'N\'Roll !' ) {
		parent::__construct(array('length' => 1, 'width' => 5, 'hp' => 6, 'pp' => 10, 'speed' => 12, 'handle' => 4, 'weapons' => array(new MakroKanon()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>