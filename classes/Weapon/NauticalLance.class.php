<?php
require_once 'Weapon.class.php';

class NauticalLance extends Weapon {
	public static function doc() {
		return file_get_contents('./NauticalLance.doc.txt');
	}

	public function __construct() {
		parent::__construct(array('charge' => 0, 'short' => 30, 'middle' => 60, 'long' => 90));
	}
}
?>