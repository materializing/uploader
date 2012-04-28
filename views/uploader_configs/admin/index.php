<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイルアップローダー設定 フォーム
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
 * @package			baser.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>
<script type="text/javascript">
$(window).load(function() {
	$("#UploaderConfigLargeWidth").focus();
});
</script>

<!-- form -->
<?php echo $bcForm->create('UploaderConfig', array('action' => 'index')) ?>

<h2>画像サイズ設定</h2>

<div class="section">
	<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
		<tr>
			<th><span class="required">*</span>&nbsp;
				<?php echo $bcForm->label('UploaderConfig.large_width', 'PCサイズ（大）') ?>
			</th>
			<td>
				<small>[幅]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.large_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
				<small>[高さ]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.large_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
				<?php echo $bcForm->error('UploaderConfig.large_width') ?>
				<?php echo $bcForm->error('UploaderConfig.large_height') ?>
			</td>
		</tr>
		<tr>
			<th><span class="required">*</span>&nbsp;
				<?php echo $bcForm->label('UploaderConfig.midium_width', 'PCサイズ（中）') ?>
			</th>
			<td>
				<small>[幅]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.midium_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
				<small>[高さ]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.midium_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
				<?php echo $bcForm->error('UploaderConfig.midium_width') ?>
				<?php echo $bcForm->error('UploaderConfig.midium_height') ?>
			</td>
		</tr>
		<tr>
			<th><span class="required">*</span>&nbsp;
				<?php echo $bcForm->label('UploaderConfig.small_width', 'PCサイズ（小）') ?>
			</th>
			<td>
				<small>[幅]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.small_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
				<small>[高さ]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.small_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　
				<?php echo $bcForm->input('UploaderConfig.small_thumb', array('type' => 'checkbox', 'label' => '正方形に切り抜く', 'between' => '&nbsp;')) ?>
				<?php echo $bcForm->error('UploaderConfig.small_width') ?>
				<?php echo $bcForm->error('UploaderConfig.small_height') ?>
				<?php echo $bcForm->error('UploaderConfig.small_thumb') ?>
			</td>
		</tr>
		<tr>
			<th><span class="required">*</span>&nbsp;
				<?php echo $bcForm->label('UploaderConfig.mobile_large_width', '携帯サイズ（大）') ?>
			</th>
			<td>
				<small>[幅]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.mobile_large_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
				<small>[高さ]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.mobile_large_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px
				<?php echo $bcForm->error('UploaderConfig.mobile_large_width') ?>
				<?php echo $bcForm->error('UploaderConfig.mobile_large_height') ?>
			</td>
		</tr>
		<tr>
			<th><span class="required">*</span>&nbsp;
				<?php echo $bcForm->label('UploaderConfig.mobile_small_width', '携帯サイズ（小）') ?>
			</th>
			<td>
				<small>[幅]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.mobile_small_width', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　×　
				<small>[高さ]</small>&nbsp;<?php echo $bcForm->input('UploaderConfig.mobile_small_height', array('type' => 'text', 'size' => 8,'maxlength' => 8)) ?>&nbsp;px　
				<?php echo $bcForm->input('UploaderConfig.mobile_small_thumb', array('type' => 'checkbox', 'label' => '正方形に切り抜く', 'between' => '&nbsp;')) ?>
				<?php echo $bcForm->error('UploaderConfig.mobile_small_width') ?>
				<?php echo $bcForm->error('UploaderConfig.mobile_small_height') ?>
				<?php echo $bcForm->error('UploaderConfig.mobile_small_thumb') ?>
			</td>
		</tr>
	</table>
</div>

<?php if($user['user_group_id'] == 1): ?>
<h2 class="btn-slide-form"><a href="javascript:void(0)" id="FormOption">オプション</a></h2>


<div id ="FormOptionBody" class="slide-body section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head"><span class="required">*</span>&nbsp;<?php echo $bcForm->label('UploaderConfig.use_permission', '制限設定') ?></th>
			<td class="col-input">
				<?php echo $bcForm->input('UploaderConfig.use_permission', array('type' => 'checkbox', 'label' => '編集/削除を制限する', 'between' => '&nbsp;')) ?>
				<?php echo $html->image('admin/icn_help.png', array('class' => 'btn help', 'alt' => 'ヘルプ')) ?>
				<?php echo $bcForm->error('UploaderConfig.use_permission') ?>
				<div id="helptextUsePermission" class="helptext">
					管理者以外のユーザーは、自分がアップロードしたファイル以外、編集・削除をできないようにします。
				</div>
			</td>
		</tr>
	</table>
</div>
<?php endif ?>

<!-- button -->
<div class="submit">
	<?php echo $bcForm->submit('更　新', array('div' => false, 'class' => 'btn-orange button', 'id' => 'btnSubmit')) ?>
</div>

<?php echo $bcForm->end() ?>
