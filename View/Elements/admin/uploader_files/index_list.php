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

<div id="DivTableList">

<?php if($listId): ?>
<div id="UploaderForm">
	<?php if(!$installMessage): ?>
	<div>
		<?php if($uploaderCategories): ?>
		<?php echo $this->BcForm->input('UploaderFile.uploader_category_id', array('type' => 'select', 'options' => $uploaderCategories, 'empty' => 'カテゴリ指定なし', 'id' => 'UploaderFileUploaderCategoryId'.$listId, 'style' => 'width:100px')) ?>&nbsp;
		<?php endif ?>
		<span id="SpanUploadFile<?php echo $listId ?>">
			<?php echo $this->BcForm->file('UploaderFile.file', array('id'=>'UploaderFileFile'.$listId, 'class' => 'uploader-file-file')) ?>
		</span>
	</div>
	<?php endif ?>
</div>
<?php endif ?>

<?php $this->BcBaser->element('pagination') ?>

<?php if($installMessage): ?>
<p style="color:#C00;font-weight:bold"><?php echo $installMessage ?></p>
<?php endif ?>


<div class="file-list-body clearfix corner5">
		
<table class="list-table">

<thead>
	<tr>
<?php if(!$listId): ?>
		<th id="UploaderForm">
	<?php if(!$installMessage): ?>
			<div>
		<?php if($uploaderCategories): ?>
				<?php echo $this->BcForm->input('UploaderFile.uploader_category_id', array('type' => 'select', 'options' => $uploaderCategories, 'empty' => 'カテゴリ指定なし', 'id' => 'UploaderFileUploaderCategoryId'.$listId, 'style' => 'width:100px')) ?><br />
		<?php endif ?>
				<span id="SpanUploadFile<?php echo $listId ?>">
					<?php echo $this->BcForm->file('UploaderFile.file', array('id'=>'UploaderFileFile'.$listId, 'class' => 'uploader-file-file')) ?>
				</span>
			</div>
	<?php endif ?>
		</th>
<?php endif ?>
		<th>NO</th>
		<th>イメージ</th>
		<th>カテゴリ</th>
		<th>ファイル名<br />説明文</th>
		<th>投稿者</th>
		<th>投稿日<br />編集日</th>
	</tr>
</thead>
<?php if ($files): ?>
<tbody>
	<?php foreach ($files as $file): ?>
		<?php $this->BcBaser->element('uploader_files/index_row', array('file' => $file, 'users' => $users, 'uploaderCategories' => $uploaderCategories)) ?>
	<?php endforeach ?>
</tbody>
<?php else: ?>
<tbody><tr><td colspan="7" class="no-data">ファイルが存在しません</td></tr></tbody>
<?php endif ?>
</table>

</div>

</div>