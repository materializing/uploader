<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] 絞りこみ
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
$uploaderCategories = $bcForm->getControlSource("UploaderFile.uploader_category_id");
if(!isset($listId)) {
	$listId = $this->getVar('listId');
}
?>


<div class="file-filter submit">
	<small style="font-weight:bold">名称</small>&nbsp;<?php echo $bcForm->input('Filter.name', array('type' => 'text', 'id' => 'FilterName'.$listId, 'class' => 'filter-control', 'style' => 'width:160px')) ?>　
<?php if($uploaderCategories): ?>
	<small style="font-weight:bold">カテゴリ</small>&nbsp;<?php echo $bcForm->input('Filter.uploader_category_id', array('type' => 'select', 'options' => $uploaderCategories, 'empty' => '指定なし', 'id' => 'FilterUploaderCategoryId'.$listId, 'class' => 'filter-control')) ?>　
<?php endif ?>
	<small style="font-weight:bold">タイプ</small>&nbsp;<?php echo $bcForm->input('Filter.uploader_type', array('type' => 'radio', 'options' => array('all'=>'指定なし', 'img' => '画像', 'etc' => '画像以外'), 'id' => 'FilterUploaderType'.$listId, 'class' => 'filter-control')) ?>
	<?php echo $bcForm->submit('検索', array('id' => 'BtnFilter'.$listId, 'div' => false, 'class' => 'button filter-control')) ?>
</div>