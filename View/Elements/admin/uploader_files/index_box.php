<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルパネル
 *
 * PHP versions 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2013, Catchup, Inc.
 *								1-19-4 ikinomatsubara, fukuoka-shi
 *								fukuoka, Japan 819-0055
 *
 * @copyright		Copyright 2008 - 2013, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
$classies = array();
if (!$this->Uploader->isPublish($file)) {
	$classies = array('unpublish', 'disablerow', 'selectable-file');
	$statusPublish = false;
} else {
	$classies = array('publish', 'selectable-file');
	$statusPublish = true;
}
$class = ' class="' . implode(' ', $classies) . '"';
?>
<span<?php echo $class; ?> id="selectedFile<?php echo $file['UploaderFile']['id'] ?>">
	<?php echo $this->Uploader->file($file, array(
		'width' => 120,
		'height'=> 120,
		'size'	=> 'small',
		'alt'	=> $file['UploaderFile']['alt'],
		'style' => 'width:120px;height:120px'
	)) ?>
	<div style="text-align:right">
		<span class="id"><?php echo $file['UploaderFile']['id'] ?></span>.<span><?php echo $this->BcText->truncate($file['UploaderFile']['alt'], 13) ?></span>
	</div>
	<span class="name"><?php echo $file['UploaderFile']['name'] ?></span>
	<div style="text-align:right;margin-top:2px">
		<span class="created">
			[公開状態：<?php echo $this->BcText->booleanMark($statusPublish); ?>]&nbsp;<?php echo $this->BcTime->format('Y.m.d',$file['UploaderFile']['created']) ?>
		</span>
	</div>
	<div class="user-name" style="text-align:right"><span><?php echo $this->BcText->arrayValue($file['UploaderFile']['user_id'], $users) ?></span></div>
	<div style="display:none">
		<span class="modified"><?php echo $this->BcTime->format('Y.m.d',$file['UploaderFile']['modified']) ?></span>
		<span class="small"><?php echo $file['UploaderFile']['small'] ?></span>
		<span class="midium"><?php echo $file['UploaderFile']['midium'] ?></span>
		<span class="large"><?php echo $file['UploaderFile']['large'] ?></span>
		<span class="url"><?php echo $this->BcHtml->url($this->Uploader->getFileUrl($file['UploaderFile']['name'])) ?></span>
		<span class="user-id"><?php echo $file['UploaderFile']['user_id'] ?></span>
		<span class="publish-begin"><?php echo $this->BcTime->format('Y/m/d', $file['UploaderFile']['publish_begin']) ?></span>
		<span class="publish-begin-time"><?php echo $this->BcTime->format('H:i:s', $file['UploaderFile']['publish_begin']) ?></span>
		<span class="publish-end"><?php echo $this->BcTime->format('Y/m/d', $file['UploaderFile']['publish_end']) ?></span>
		<span class="publish-end-time"><?php echo $this->BcTime->format('H:i:s', $file['UploaderFile']['publish_end']) ?></span>
		<span class="uploader-category-id"><?php echo $file['UploaderFile']['uploader_category_id'] ?></span>
		<span class="alt"><?php echo $file['UploaderFile']['alt'] ?></span>
	</div>
</span>