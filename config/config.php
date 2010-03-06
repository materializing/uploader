<?php
$adminLink = '/admin/uploader/uploader_files/index';
$title = 'アップローダー';
if(!is_writable(WWW_ROOT.'files')){
	$viewFilesPath = str_replace(ROOT,'',WWW_ROOT).'files';	
	$installMessage = '登録ボタンをクリックする前に、サーバー上の '.$viewFilesPath.' に書き込み権限を与えてください。';
}
?>