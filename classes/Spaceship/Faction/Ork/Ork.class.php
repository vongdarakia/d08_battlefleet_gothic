<?php
require_once __DIR__ . '/../../Spaceship.class.php';

class Ork extends Spaceship {
	public static function doc() {
		return file_get_contents('./Ork.doc.txt');
	}
}
?>