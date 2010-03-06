<?php
/* SVN FILE: $Id$ */
/**
 * Updaterフックヘルパー
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
 * @package			updater.views.helpers
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
class UploaderHookHelper extends AppHelper{
/**
 * afterLayout
 */
	function afterLayout(){

		$view =& ClassRegistry::getObject('view');

        if($view){
            if(isset($view->loaded['ckeditor'])){
                if(preg_match_all("/var\s*?(editor_[a-z0-9]*?)\s*?=\s*?CKEDITOR.replace/s",$view->output,$matches)){
                    $script = '<link rel="stylesheet" type="text/css" href="'.$this->webroot('/uploader/css/uploader.css').'" />';
                    $script .= "<script type=\"text/javascript\">var baseUrl ='".$this->base.'/'."';</script>";
                    $script .= '<script type="text/javascript" src="'.$this->webroot('/uploader/js/ckeditor_uploader.js').'"></script>';
                    $view->output = str_replace('</head>',$script.'</head>',$view->output);
                    foreach($matches[1] as $key => $match){
                        $script = str_replace('EDITOR_NAME',$match,$this->getCkeditorUploaderScript());
                        $pattern = "/(<script type=\"text\/javascript\">.*?var\s*?".$match."\s*?=\s*?CKEDITOR.replace.*?)\/\/\]\]>\n*?<\/script>/s";
                        $view->output = preg_replace($pattern,"$1".$script,$view->output);
                    }
                    //$view->output = str_replace('</body>',$script.'</body>',$view->output);
                    $pattern = "/(CKEDITOR\.replace.*?\"toolbar\".*?)\"Image\"(.*?);/is";
                    $view->output = preg_replace($pattern,"$1".'"BaserImage"'."$2;",$view->output);
                }
            }elseif(!empty($view->params['prefix']) && $view->params['prefix'] == 'mobile'){
                // モバイル画像に差し替える
                $aMatch = "/<a([^>]*?)href=\"([^>]*?)\"([^>]*?)><img([^>]*?)\/><\/a>/is";
                $imgMatch = "/<img([^>]*?)src=\"([^>]*?)\"([^>]*?)\/>/is";
                $view->output = preg_replace_callback($aMatch,array($this,"mobileImageAnchorReplace"),$view->output);
                $view->output = preg_replace_callback($imgMatch,array($this,"mobileImageReplace"),$view->output);
            }

        }

	}
/**
 * 画像タグをモバイル用に置き換える
 * @param array $matches
 * @return string
 */
    function mobileImageReplace($matches){
        $url = $matches[2];
        $pathinfo = pathinfo($url);
        if(!isset($pathinfo['extension'])){
            return $matches[0];
        }
        $url = str_replace('__small','',$url);
        $url = str_replace('__midium','',$url);
        $url = str_replace('__large','',$url);
        $basename = basename($url,'.'.$pathinfo['extension']);
        $_url = 'files'.DS.'uploads'.DS.$basename.'__mobile_small.'.$pathinfo['extension'];
        // TODO uploads固定となってしまっているのでmodelから取得するようにする
        $path = WWW_ROOT.$_url;
        if(file_exists($path)){
            return '<img'.$matches[1].'src="'.$this->webroot($_url).'"'.$matches[3].'/>';
        }else{
            return $matches[0];
        }

    }
/**
 * アンカータグのリンク先が画像のものをモバイル用に置き換える
 * @param array $matches
 * @param string
 */
    function mobileImageAnchorReplace($matches){

        $url = $matches[2];
        $pathinfo = pathinfo($url);
        if(!isset($pathinfo['extension'])){
            return $matches[0];
        }
        $basename = basename($url,'.'.$pathinfo['extension']);
        $_url = 'files'.DS.'uploads'.DS.$basename.'__mobile_large.'.$pathinfo['extension'];
        // TODO uploads固定となってしまっているのでmodelから取得するようにする
        $path = WWW_ROOT.$_url;
        if(file_exists($path)){
            return '<a'.$matches[1].'href="'.$this->webroot($_url).'"'.$matches[3].'><img'.$matches[4].'/></a>';
        }else{
            return $matches[0];
        }

    }
/**
 * CKEditorのアップローダーを組み込む為のスクリプト返す
 * @return string
 */
    function getCkeditorUploaderScript(){

        return <<< DOC_END
EDITOR_NAME.on( 'pluginsLoaded', function( ev ) {
    // baserImageを開くコマンドを追加
    EDITOR_NAME.addCommand( 'baserImage', new CKEDITOR.dialogCommand( 'baserImageDialog' ) );
    // ツールバーにボタンを追加
    EDITOR_NAME.ui.addButton( 'BaserImage', { label : 'イメージ', command : 'baserImage' });
});
//]]>
</script>
DOC_END;

    }

}
?>