<?php
/* SVN FILE: $Id$ */
/**
 * アップローダーヘルパー
 *
 * PHP versions 4 and 5
 *
 * Baser :  Basic Creating Support Project <http://basercms.net>
 * Copyright 2008 - 2009, Catchup, Inc.
 *								18-1 nagao 1-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2009, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			uploader.views.helper
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * アップローダーヘルパー
 *
 * @package			baser.plugins.uploader.views.helpers
 */
class UploaderHelper extends AppHelper {
/**
 * アップロードファイルの保存URL
 * @var string
 * @access public
 */
	var $savedUrl = '';
/**
 * アップロードファイルの保存パス
 * @var string
 */
	var $savePath = '';
/**
 * ヘルパー
 * @var array
 * @access public
 */
	var $helpers = array('Html');
/**
 * Before render
 */
	function beforeRender() {

		parent::beforeRender();
		$this->savedUrl = '/files/uploads/';
		$this->savePath = WWW_ROOT . 'files' . DS . 'uploads' . DS;

	}
/**
 * リスト用のimgタグを出力する
 * @param UploaderFile $uploaderFile
 * @param array $options
 * @return string imgタグ
 */
	function file ($uploaderFile,$options = array()) {

		if(isset($uploaderFile['UploaderFile'])) {
			$uploaderFile = $uploaderFile['UploaderFile'];
		}

		$imgUrl = $this->_getFileUrl($uploaderFile['name']);

		$pathInfo = pathinfo($uploaderFile['name']);
		$ext = $pathInfo['extension'];
		$_options = array('alt'=>$uploaderFile['alt']);
		$options = Set::merge($_options,$options);

		if(in_array(strtolower($ext), array('gif','jpg','png'))) {
			if (isset($options['size'])) {
				$basename = basename($uploaderFile['name'],'.'.$ext);
				$resizeName = $basename . '__' . $options['size'] . '.' . $ext;

				if(file_exists($this->savePath.$resizeName)) {
					$imgUrl = $this->_getFileUrl($resizeName);
					unset($options['size']);
				}
			}
			return $this->Html->image($imgUrl,$options);
		}else {
			$imgUrl = '/uploader/img/icon_upload_file.png';
			return $this->Html->image($imgUrl,$options);
		}
	}
/**
 * ファイルが保存されているURLを取得する
 * webrootメソッドによる変換なし
 * @param string $fileName
 * @return string
 * @access protected
 */
	function _getFileUrl($fileName) {
		if($fileName) {
			return $this->savedUrl.$fileName;
		}else {
			return '';
		}
	}
/**
 * ファイルが保存されているURLを取得する
 * webrootメソッドによる変換あり
 * @param string $fileName
 * @return string
 * @access public
 */
	function getFileUrl($fileName) {
		if($fileName) {
			if(Configure::read('App.baseUrl')) {
				return $this->webroot($this->savedUrl.$fileName);
			}else {
				return $this->url($this->savedUrl.$fileName);
			}
		}else {
			return '';
		}
	}
/**
 * ダウンロードリンクを表示
 * @param array $uploaderFile
 * @param string $linkText
 * @return string
 */
	function download($uploaderFile,$linkText='≫ ダウンロード') {
		if(isset($uploaderFile['UploaderFile'])) {
			$uploaderFile = $uploaderFile['UploaderFile'];
		}
		$saveUrl = $this->savedUrl;
		$fileUrl = $saveUrl.$uploaderFile['name'];
		return $this->Html->link($linkText,$fileUrl);
	}
}
?>