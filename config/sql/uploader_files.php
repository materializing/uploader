<?php 
/* SVN FILE: $Id$ */
/* UploaderFiles schema generated on: 2010-11-06 23:11:15 : 1289052015*/
class UploaderFilesSchema extends CakeSchema {
	var $name = 'UploaderFiles';

	var $path = '/Users/ryuring/Documents/Projects/basercms/app/tmp/schemas/';

	var $file = 'uploader_files.php';

	var $connection = 'baser';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $uploader_files = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'alt' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>