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
?>


<?php $bcBaser->link('ListUrl', array('action' => 'ajax_list', $listId, 'num' => $this->passedArgs['num']), array('id' => 'ListUrl'.$listId, 'style' => 'display:none')) ?>


<!-- JS用設定値 -->
<div style="display:none">
	<div id="ListId"><?php echo $listId ?></div>
	<div id="UploaderImageSettings"><?php if(isset($imageSettings)) : ?><?php echo $javascript->object($imageSettings) ?><?php endif ?></div>
	<div id="LoginUserId"><?php echo $user['id'] ?></div>
	<div id="LoginUserGroupId"><?php echo $user['user_group_id'] ?></div>
	<div id="BaseUrl"><?php echo $bcBaser->root() ?></div>
	<div id="AdminPrefix" style="display:none;"><?php echo Configure::read('Routing.admin'); ?></div>
	<div id="UsePermission"><?php echo $uploaderConfigs['use_permission'] ?></div>
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
<div id="EditDialog" title="ファイル情報編集">
	<?php $bcBaser->element('uploader_files/form', array('listId', $listId, 'popup' => true)) ?>
</div>