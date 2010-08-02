<?php
/* SVN FILE: $Id$ */
/**
 * ファイルリスト
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2009, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2009, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>
<?php $baser->pagination('default',array(),null,false) ?>
<?php if ($files): ?>
	<?php foreach ($files as $file): ?>
<span class="selectable-file" id="selectedFile<?php echo $file['UploaderFile']['id'] ?>">
	<?php echo $uploader->file($file,array('width'=>120,'height'=>120,'size'=>'small','alt'=>$file['UploaderFile']['alt'],'style'=>'width:120px;height:120px')) ?>
	<span class="id"><?php echo $file['UploaderFile']['id'] ?></span>.&nbsp;
	<span class="name"><?php echo $file['UploaderFile']['name'] ?></span><br />
	<span class="alt"><?php echo $file['UploaderFile']['alt'] ?></span>
	<span class="created"><?php echo $timeEx->format('y.m.d',$file['UploaderFile']['created']) ?></span>
	<span class="modified"><?php echo $timeEx->format('y.m.d',$file['UploaderFile']['modified']) ?></span>
	<span class="small"><?php echo $file['UploaderFile']['small'] ?></span>
	<span class="midium"><?php echo $file['UploaderFile']['midium'] ?></span>
	<span class="large"><?php echo $file['UploaderFile']['large'] ?></span>
	<span class="url"><?php echo $uploader->getFileUrl($file['UploaderFile']['name']) ?></span>
</span>
	<?php endforeach ?>
<?php else: ?>
<p class="no-data">ファイルが存在しません</p>
<?php endif ?>