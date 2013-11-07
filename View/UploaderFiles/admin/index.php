<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイル一覧
 *
 * PHP versions 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
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
$this->BcBaser->css('Uploader.uploader', array('inline' => false));
?>

<script type="text/javascript">
$(window).load(function() {
	$("#UploaderFileFile").focus();
});
</script>

<?php $this->BcBaser->element('uploader_files/index') ?>
