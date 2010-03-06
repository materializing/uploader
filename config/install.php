<?php
    $this->Plugin->initDatabase('plugin','uploader');
	$filesPath = WWW_ROOT.'files';
	$savePath = $filesPath.DS.'uploads';
	if(is_writable($filesPath) && !is_dir($savePath)){
		mkdir($savePath);
		chmod($savePath,0777);
	}
	if(!is_writable($savePath)){
		chmod($savePath,0777);
	}
?>