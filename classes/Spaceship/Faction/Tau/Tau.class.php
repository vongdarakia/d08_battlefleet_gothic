<?php
require_once __DIR__ . '/../../Spaceship.class.php';

class Tau extends Spaceship {
	public static function doc() {
		return file_get_contents('./Tau.doc.txt');
	}
}
?>