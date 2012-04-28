<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルカテゴリ一覧
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
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
?>
<tr>
	<td class="row-tools">
<?php if($bcBaser->isAdminUser()): ?>
		<?php echo $bcForm->checkbox('ListTool.batch_targets.'.$data['UploaderCategory']['id'], array('type' => 'checkbox', 'class' => 'batch-targets', 'value' => $data['UploaderCategory']['id'])) ?>
<?php endif ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_edit.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'edit', $data['UploaderCategory']['id']), array('title' => '編集')) ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_copy.png', array('width' => 24, 'height' => 24, 'alt' => 'コピー', 'class' => 'btn')), array('action' => 'ajax_copy', $data['UploaderCategory']['id']), array('title' => 'コピー', 'class' => 'btn-copy')) ?>
		<?php $bcBaser->link($bcBaser->getImg('admin/icn_tool_delete.png', array('width' => 24, 'height' => 24, 'alt' => '削除', 'class' => 'btn')), array('action' => 'ajax_delete', $data['UploaderCategory']['id']), array('title' => '削除', 'class' => 'btn-delete')) ?>
	</td>
	<td><?php echo $data['UploaderCategory']['id'] ?></td>
	<td><?php echo $data['UploaderCategory']['name'] ?></td>
	<td>
		<?php echo $data['UploaderCategory']['created'] ?><br />
		<?php echo $data['UploaderCategory']['modified'] ?>
	</td>
</tr>
