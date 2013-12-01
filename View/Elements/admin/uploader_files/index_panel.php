<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルリスト
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
// IE文字化け対策
header('Content-type: text/html; charset=utf-8');
$users = $this->BcForm->getControlSource("UploaderFile.user_id");
$uploaderCategories = $this->BcForm->getControlSource("UploaderFile.uploader_category_id");
$this->passedArgs['action'] = 'ajax_list';
//==============================================================================
// Ajaxで呼び出される事が前提の為インラインで呼びだし
//==============================================================================
$this->BcBaser->js('admin/jquery.upload-1.0.0.min');
?>


<div id="DivPanelList">

<?php $this->BcBaser->element('pagination') ?>

<!-- form -->
<?php if(!$installMessage): ?>
<div id="UploaderForm" class="clearfix">
	<div>
		<?php echo $this->BcForm->label('UploaderFile.uploader_category_id', 'アップロード') ?>&nbsp;
	<?php if($uploaderCategories): ?>
		<?php echo $this->BcForm->input('UploaderFile.uploader_category_id', array('type' => 'select', 'options' => $uploaderCategories, 'empty' => 'カテゴリ指定なし', 'id' => 'UploaderFileUploaderCategoryId'.$listId)) ?>&nbsp;
	<?php endif ?>
		<span id="SpanUploadFile<?php echo $listId ?>">
			<?php echo $this->BcForm->file('UploaderFile.file', array('id'=>'UploaderFileFile'.$listId, 'class' => 'uploader-file-file')) ?>
		</span>
	</div>
</div>
<?php else: ?>
<p style="color:#C00;font-weight:bold"><?php echo $installMessage ?></p>
<?php endif ?>

<div class="file-list-body clearfix corner5">
<?php if ($files): ?>
	<?php foreach ($files as $file): ?>
		<?php $this->BcBaser->element('uploader_files/index_box', array('file' => $file, 'users' => $users)) ?>
	<?php endforeach ?>
<?php else: ?>
<p class="no-data">ファイルが存在しません</p>
<?php endif ?>
</div>

</div>