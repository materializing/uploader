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


<!-- list-num -->
<?php $bcBaser->element('list_num') ?>

<!-- pagination -->

<?php $bcBaser->element('pagination') ?>

<!-- list -->
<table cellpadding="0" cellspacing="0" class="form-table" id="TableUploaderCategories">
	<tr>
		<th style="width:100px">操作</th>
		<th><?php echo $paginator->sort(array('asc'=>'NO ▼','desc'=>'NO ▲'),'id'); ?></th>
		<th><?php echo $paginator->sort(array('asc'=>'カテゴリ名 ▼','desc'=>'カテゴリ名 ▲'),'name'); ?></th>
		<th><?php echo $paginator->sort(array('asc'=>'登録日 ▼','desc'=>'登録日 ▲'),'created'); ?><br />
			<?php echo $paginator->sort(array('asc'=>'更新日 ▼','desc'=>'更新日 ▲'),'modified'); ?></th>
	</tr>
<?php if(!empty($datas)): ?>
	<?php $count=0; ?>
	<?php foreach($datas as $data) : ?>
		<?php if ($count%2 === 0): ?>
			<?php $class=' class="altrow"'; ?>
		<?php else: ?>
			<?php $class=''; ?>
		<?php endif; ?>
		<?php $count++ ?>
	<tr<?php echo $class; ?>>
		<td class="operation-button">
			<?php $bcBaser->link('編集',array('action'=>'edit', $data['UploaderCategory']['id']),array('class'=>'btn-orange-s button-s'),null,false) ?>
			<?php $bcBaser->link('削除', array('action'=>'delete', $data['UploaderCategory']['id']), array('class'=>'btn-gray-s button-s'), sprintf('%s を本当に削除してもいいですか？', $data['UploaderCategory']['name']),false); ?></td>
		<td><?php echo $data['UploaderCategory']['id'] ?></td>
		<td><?php echo $data['UploaderCategory']['name'] ?></td>
		<td>
			<?php echo $data['UploaderCategory']['created'] ?><br />
			<?php echo $data['UploaderCategory']['modified'] ?>
		</td>
	</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr><td colspan="8"><p class="no-data">データが見つかりませんでした。</p></td></tr>
<?php endif; ?>
</table>

<!-- pagination -->
<?php $bcBaser->element('pagination') ?>
