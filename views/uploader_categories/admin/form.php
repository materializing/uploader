<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルカテゴリフォーム
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

<script type="text/javascript">
$(window).load(function() {
	$("#UploaderCategoryName").focus();
});
</script>

<!-- form -->
<?php echo $bcForm->create('UploaderCategory') ?>
<?php echo $bcForm->input('UploaderCategory.id', array('type' => 'hidden')) ?>

<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
<?php if($this->action == 'admin_edit'): ?>
	<tr>
		<th><?php echo $bcForm->label('UploaderCategory.id', 'NO') ?></th>
		<td>
			<?php echo $bcForm->value('UploaderCategory.id') ?>
			<?php echo $bcForm->input('UploaderCategory.id', array('type' => 'hidden')) ?>
		</td>
	</tr>
<?php endif; ?>
	<tr>
		<th><?php echo $bcForm->label('UploaderCategory.name', 'カテゴリ名') ?>&nbsp;<span class="required">*</span></th>
		<td>
			<?php echo $bcForm->input('UploaderCategory.name', array('type' => 'text', 'size' => 40, 'maxlength' => 50)) ?>
			<?php echo $bcForm->error('UploaderCategory.name') ?>
		</td>
	</tr>
</table>

<div class="submit">
<?php if($this->action == 'admin_add'): ?>
	<?php echo $bcForm->submit('登　録', array('div' => false, 'class' => 'button')) ?>
<?php else: ?>
	<?php echo $bcForm->submit('更　新', array('div' => false, 'class' => 'button')) ?>
	<?php $bcBaser->link('削　除',
			array('action' => 'delete', $bcForm->value('UploaderCategory.id')),
			array('class' => 'button'),
			sprintf('%s を本当に削除してもいいですか？', $bcForm->value('UploaderCategory.name')),
			false); ?>
<?php endif ?>
</div>

<?php echo $bcForm->end() ?>
