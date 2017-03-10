<?php
require_once '../Spaceship.class.php';

class Chaos {
	public static function doc() {
		return file_get_contents('./Chaos.doc.txt');
	}
}
?>