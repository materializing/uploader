<?php
/* SVN FILE: $Id$ */
/**
 * ファイルアップローダーモデル
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
 * @package			uploader.models
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * Include files
 */
/**
 * ファイルアップローダーモデル
 *
 * @package			baser.plugins.uploader.models
 */
class UploaderFile extends AppModel {
/**
 * モデル名
 * @var     string
 * @access  public
 */
	var $name = 'UploaderFile';
/**
 * データソース
 *
 * @var		string
 * @access 	public
 */
	var $useDbConfig = 'plugin';
/**
 * プラグイン名
 *
 * @var		string
 * @access 	public
 */
	var $plugin = 'Uploader';
/**
 * behaviors
 *
 * @var 	array
 * @access 	public
 */
	var $actsAs= array('Upload'=>
			array('saveDir'=>"uploads",
					'fields'=> array(
						'name'=>array('type'=>'all',
							/*'imageresize'=>array('width'=>'0', 'height'=>'0'),*/
							'imagecopy'=>array(
								'large'=>array('suffix'=>'__large', 'width'=>'500', 'height'=>'500'),
								'midium'=>array('suffix'=>'__midium','width'=>'300', 'height'=>'300'),
								'small'=>array('suffix'=>'__small','width'=>'150', 'height'=>'150', 'thumb'=>true),
								'mobile_large'=>array('suffix'=>'__mobile_large','width'=>'240', 'height'=>'240'),
								'mobile_small'=>array('suffix'=>'__mobile_small','width'=>'100', 'height'=>'100', 'thumb'=>true))))));
/**
 * ファイルの存在チェックを行う
 *
 * @param	string	$fileName
 * @return	void
 * @access	boolean
 */
	function fileExists($fileName) {

		$savePath = WWW_ROOT . 'files' . DS . $this->actsAs['Upload']['saveDir'] . DS . $fileName;
		return file_exists($savePath);

	}
/**
 * 複数のファイルの存在チェックを行う
 * 
 * @param	string	$basename
 * @return	array
 * @access	void
 */
	function filesExists($fileName) {

		$pathinfo = pathinfo($fileName);
		$ext = $pathinfo['extension'];
		$basename = basename($fileName,'.'.$ext);
		$files['small'] = $this->fileExists($basename.'__small'.'.'.$ext);
		$files['midium'] = $this->fileExists($basename.'__midium'.'.'.$ext);
		$files['large'] = $this->fileExists($basename.'__large'.'.'.$ext);
		return $files;

	}

}
?>