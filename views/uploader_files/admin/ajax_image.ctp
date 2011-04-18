<?php
/* SVN FILE: $Id$ */
/**
 * ファイルリスト
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2011, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
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
$url = FULL_BASE_URL.$uploader->getFileUrl($file['UploaderFile']['name']);
?>
<p class="url"><?php echo $baser->link($url, $url, array('target' => '_blank')) ?></p>
<p class="image"><?php echo $baser->link($uploader->file($file, array('size' => $size,'alt' => $file['UploaderFile']['name'])), $url, array('target' => '_blank')) ?></p>