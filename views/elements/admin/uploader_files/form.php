<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] 編集フォーム
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								1-19-4 ikinomatsubara, fukuoka-shi
 *								fukuoka, Japan 819-0055
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
if(!isset($uploaderCategories)) {
	$uploaderCategories = $bcForm->getControlSource("UploaderFile.uploader_category_id");
}
if(!isset($listId)) {
	$listId = '';
}
if(empty($popup)) {
	$users = $bcForm->getControlSource("UploaderFile.user_id");
}
?>


<?php if(empty($popup)): ?>
<div id="BaseUrl" style="display:none;"><?php echo $bcBaser->root() ?></div>
<script type="text/javascript">
$(function(){
	var name = $("#UploaderFileName").val();
	var imgUrl = $("#BaseUrl").html()+'admin/uploader/uploader_files/ajax_image/'+name+'/midium';
	$.get(imgUrl,function(res){
		$("#UploaderFileImage").html(res);
	});	
});
</script>


<div class="em-box align-left">
	<?php $url = $uploader->getFileUrl($this->data['UploaderFile']['name']) ?>
	<strong>このファイルのURL：<?php $bcBaser->link($bcBaser->getUri($url), $url) ?></strong>
</div>
<?php endif ?>


<?php if(!empty($popup)): ?>
	<?php echo $bcForm->create('UploaderFile',array('action' => 'edit', 'id' => 'UploaderFileEditForm'.$listId)) ?>
<?php else: ?>
	<?php echo $bcForm->create('UploaderFile',array('action' => 'edit', 'url' => array($this->data['UploaderFile']['id'], $listId), 'id' => 'UploaderFileEditForm'.$listId, 'type' => 'file')) ?>
<?php endif ?>


<table cellpadding="0" cellspacing="0" class="form-table">
	<tr>
		<th class="col-head"><?php echo $bcForm->label('UploaderFile.id', 'NO') ?></th>
		<td class="col-input">
			<?php echo $bcForm->text('UploaderFile.id', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileId'.$listId, 'class' => 'uploader-file-id')) ?>&nbsp;
		</td>
	</tr>
<?php if(empty($popup)): ?>
	<tr><th>アップロードファイル</th><td><?php echo $bcUpload->file('UploaderFile.name', array('delCheck' => false)) ?></td></tr>
<?php else: ?>
	<tr>
		<th class="col-head"><!--<span class="required">*</span>&nbsp;--><?php echo $bcForm->label('UploaderFile.name', 'ファイル名') ?></th>
		<td class="col-input">
			<?php echo $bcForm->text('UploaderFile.name', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileName'.$listId, 'class' => 'uploader-file-name')) ?>
			<?php echo $bcForm->error('UploaderFile.name', 'ファイル名を入力して下さい') ?>&nbsp;
		</td>
	</tr>
<?php endif ?>
	<tr>
		<th class="col-head"><?php echo $bcForm->label('UploaderFile.real_name_1', '説明文') ?></th>
		<td class="col-input">
			<?php echo $bcForm->text('UploaderFile.alt', array('size'=>30,'maxlength'=>255,'id'=>'UploaderFileAlt'.$listId)) ?>&nbsp;
		</td>
	</tr>
<?php if($uploaderCategories): ?>
	<tr>
		<th class="col-head"><?php echo $bcForm->label('UploaderFile.real_name_1', 'カテゴリ') ?></th>
		<td class="col-input">
			<?php echo $bcForm->input('UploaderFile.uploader_category_id', array('type' => 'select', 'options' => $uploaderCategories, 'empty' => '指定なし', 'id' => '_UploaderFileUploaderCategoryId'.$listId)) ?>
		</td>
	</tr>
<?php endif ?>
	<tr>
		<th class="col-head">保存者</th>
		<td class="col-input">
			<span id="UploaderFileUserName<?php echo $listId ?>">
			<?php if(empty($popup)): ?>
				<?php echo $bcText->arrayValue($this->data['UploaderFile']['user_id'], $users) ?>
			<?Php endif ?>
			</span>
			<?php echo $bcForm->input('UploaderFile.user_id', array('type' => 'hidden', 'id' => 'UploaderFileUserId'.$listId)) ?>
		</td>
	</tr>
<?php if(!empty($popup)): ?>
	<tr><td colspan="2" id="UploaderFileImage<?php echo $listId ?>" class="uploader-file-image"><?php echo $html->image('ajax-loader.gif') ?></td></tr>
<?php endif ?>
</table>


<?php if(empty($popup)): ?>
<div class="submit">
	<?php echo $bcForm->submit('保存', array('div' => false, 'class' => 'button', 'id' => 'BtnSave')) ?>
	<?php $bcBaser->link('削除',
			array('action' => 'delete', $bcForm->value('UploaderFile.id')),
			array('class' => 'button'),
			sprintf('%s を本当に削除してもいいですか？', $bcForm->value('UploaderFile.name')),
			false); ?>
</div>
<?php endif; ?>

<?php echo $bcForm->end() ?>