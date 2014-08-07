<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルカテゴリ一覧
 *
 * PHP versions 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
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
?>
<?php $this->BcBaser->element('pagination') ?>

<table cellpadding="0" cellspacing="0" class="list-table sort-table" id="ListTable">
	<thead>
		<tr>
			<th class="list-tool">
				<?php $newCatAddable = true; ?>
				<?php if($newCatAddable): ?>
				<div>
					<?php $this->BcBaser->link($this->BcBaser->getImg('admin/btn_add.png', array('width' => 69, 'height' => 18, 'alt' => '新規追加', 'class' => 'btn')), array('action' => 'add')) ?>
				</div>
				<?php endif ?>
				<?php if($this->BcBaser->isAdminUser()): ?>
					<div>
						<?php echo $this->BcForm->checkbox('ListTool.checkall', array('title' => '一括選択')) ?>
						<?php echo $this->BcForm->input('ListTool.batch', array('type' => 'select', 'options' => array('del' => '削除'), 'empty' => '一括処理')) ?>
						<?php echo $this->BcForm->button('適用', array('id' => 'BtnApplyBatch', 'disabled' => 'disabled')) ?>
					</div>
				<?php endif ?>
			</th>
			<th style="white-space: nowrap">
				<?php echo $this->Paginator->sort('id', array(
					'asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) .' NO',
					'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) .' NO'), array('escape' => false, 'class' => 'btn-direction')) ?>
			</th>
			<th style="white-space: nowrap">
				<?php echo $this->Paginator->sort('name', array(
					'asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) .' カテゴリ名',
					'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) .' カテゴリ名'), array('escape' => false, 'class' => 'btn-direction')) ?>
			</th>
			<th style="white-space: nowrap">
				<?php echo $this->Paginator->sort('created', array(
					'asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) .' 登録日',
					'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) .' 登録日'), array('escape' => false, 'class' => 'btn-direction')) ?>
				<br />
				<?php echo $this->Paginator->sort('modified', array(
					'asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) .' 更新日',
					'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) .' 更新日'), array('escape' => false, 'class' => 'btn-direction')) ?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($datas)): ?>
			<?php foreach($datas as $data): ?>
				<?php $this->BcBaser->element('uploader_categories/index_row', array('data' => $data)) ?>
			<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="4"><p class="no-data">データが見つかりませんでした。</p></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>

<!-- list-num -->
<?php $this->BcBaser->element('list_num') ?>
