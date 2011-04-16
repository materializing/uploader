<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルアップローダー設定 フォーム
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2011, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			baser.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>

<!-- title -->
<h2><?php $baser->contentsTitle() ?></h2>

<p><small><span class="required">*</span> 印の項目は必須です。</small></p>

<!-- form -->
<?php echo $formEx->create('UploaderConfig', array('action' => 'index')) ?>

<h3>画像サイズ設定</h3>

<table cellpadding="0" cellspacing="0" class="admin-row-table-01">
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $formEx->label('UploaderConfig.large_width', 'PCサイズ（大）') ?></th>
		<td class="col-input">
			<small>[幅]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.large_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
			<small>[高さ]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.large_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
			<?php echo $formEx->error('UploaderConfig.large_width') ?>
			<?php echo $formEx->error('UploaderConfig.large_height') ?>
		</td>
	</tr>
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $formEx->label('UploaderConfig.midium_width', 'PCサイズ（中）') ?></th>
		<td class="col-input">
			<small>[幅]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.midium_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
			<small>[高さ]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.midium_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
			<?php echo $formEx->error('UploaderConfig.midium_width') ?>
			<?php echo $formEx->error('UploaderConfig.midium_height') ?>
		</td>
	</tr>
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $formEx->label('UploaderConfig.small_width', 'PCサイズ（小）') ?></th>
		<td class="col-input">
			<small>[幅]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.small_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
			<small>[高さ]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.small_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　
			<?php echo $formEx->input('UploaderConfig.small_thumb', array('type' => 'checkbox', 'label' => '正方形に切り抜く', 'between' => '&nbsp;')) ?>
			<?php echo $formEx->error('UploaderConfig.small_width') ?>
			<?php echo $formEx->error('UploaderConfig.small_height') ?>
			<?php echo $formEx->error('UploaderConfig.small_thumb') ?>
		</td>
	</tr>
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $formEx->label('UploaderConfig.mobile_large_width', '携帯サイズ（大）') ?></th>
		<td class="col-input">
			<small>[幅]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.mobile_large_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
			<small>[高さ]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.mobile_large_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
			<?php echo $formEx->error('UploaderConfig.mobile_large_width') ?>
			<?php echo $formEx->error('UploaderConfig.mobile_large_height') ?>
		</td>
	</tr>
	<tr>
		<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $formEx->label('UploaderConfig.mobile_small_width', '携帯サイズ（小）') ?></th>
		<td class="col-input">
			<small>[幅]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.mobile_small_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
			<small>[高さ]</small>&nbsp;<?php echo $formEx->input('UploaderConfig.mobile_small_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　
			<?php echo $formEx->input('UploaderConfig.mobile_small_thumb', array('type' => 'checkbox', 'label' => '正方形に切り抜く', 'between' => '&nbsp;')) ?>
			<?php echo $formEx->error('UploaderConfig.mobile_small_width') ?>
			<?php echo $formEx->error('UploaderConfig.mobile_small_height') ?>
			<?php echo $formEx->error('UploaderConfig.mobile_small_thumb') ?>
		</td>
	</tr>
</table>

<!-- button -->
<div class="align-center">
	<?php echo $formEx->submit('更　新', array('div' => false, 'class' => 'btn-orange button', 'id' => 'btnSubmit')) ?>
</div>

<?php echo $formEx->end() ?>