<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイル一覧
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
$bcBaser->js(array('/uploader/js/uploader_list'));
if(!isset($listId)) {
	$listId = '';
}
$uploaderCategories = $bcForm->getControlSource('UploaderFile.uploader_category_id');
?>


<?php $bcBaser->link('ListUrl', array('action' => 'ajax_list', $listId, 'num' => $this->passedArgs['num']), array('id' => 'ListUrl'.$listId, 'style' => 'display:none')) ?>


<!-- JS用設定値 -->
<div style="display:none">
	<div id="UploaderImageSettings"><?php if(isset($imageSettings)) : ?><?php echo $javascript->object($imageSettings) ?><?php endif ?></div>
	<div id="LoginUserId"><?php echo $user['id'] ?></div>
	<div id="LoginUserGroupId"><?php echo $user['user_group_id'] ?></div>
	<div id="BaseUrl"><?php echo $bcBaser->root() ?></div>
	<div id="UsePermission"><?php echo $uploaderConfigs['use_permission'] ?></div>
	<div id="ListId"><?php echo $listId ?></div>
</div>


<!-- ファイルリスト -->
<div id="FileList<?php echo $listId ?>" class="corner5 file-list"></div>


<!-- list-num -->
<?php if(empty($this->params['isAjax'])): ?>
<?php $bcBaser->element('list_num') ?>
<?php endif ?>


<!-- コンテキストメニュー -->
<ul id="FileMenu1" class="context-menu">
    <li class="edit"><a href="#edit">編集</a></li>
    <li class="delete"><a href="#delete">削除</a></li>
</ul>
<ul id="FileMenu2" class="context-menu">
    <li class="edit disabled"><a href="#">編集</a></li>
    <li class="delete disabled"><a href="#">削除</a></li>
</ul>


<!-- 編集ダイアログ -->
<div id="dialog" title="ファイル情報編集">
	<?php echo $bcForm->create('UploaderFile',array('action' => 'edit', 'id' => 'UploaderFileEditForm'.$listId)) ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th class="col-head"><?php echo $bcForm->label('UploaderFile.id', 'NO') ?></th>
            <td class="col-input">
				<?php echo $bcForm->text('UploaderFile.id', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileId'.$listId, 'class' => 'uploader-file-id')) ?>&nbsp;
            </td>
        </tr>
		<tr>
			<th class="col-head"><!--<span class="required">*</span>&nbsp;--><?php echo $bcForm->label('UploaderFile.name', 'ファイル名') ?></th>
			<td class="col-input">
				<?php echo $bcForm->text('UploaderFile.name', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileName'.$listId, 'class' => 'uploader-file-name')) ?>
				<?php echo $bcForm->error('UploaderFile.name', 'ファイル名を入力して下さい') ?>&nbsp;
			</td>
		</tr>
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
				<span id="UploaderFileUserName<?php echo $listId ?>">&nbsp;</span>
				<?php echo $bcForm->input('UploaderFile.user_id', array('type' => 'hidden', 'id' => 'UploaderFileUserId'.$listId)) ?>
			</td>
		</tr>
		<tr><td colspan="2" id="UploaderFileImage<?php echo $listId ?>" class="uploader-file-image"><?php echo $html->image('ajax-loader.gif') ?></td></tr>
    </table>
	<?php echo $bcForm->end() ?>
</div>