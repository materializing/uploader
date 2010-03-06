/* SVN FILE: $Id$ */
/**
 * ファイルアップロードダイアログ用CKEditorスクリプト
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
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
if ( !CKEDITOR.dialog.exists( 'Image' ) )
{

    // ダイアログを登録する
    CKEDITOR.dialog.add( 'baserImageDialog', function( editor )
    {
        return {
            title : 'イメージプロパティ',
            minWidth : 720,
            minHeight : 420,
            whiteSpace : 'normal',
        /**
         * 起動時
         **/
            onShow : function()
            {
                this.editMode = false;
                var element = this.getParentEditor().getSelection().getSelectedElement();
                if ( element && element.getName() == 'img' ){
                    this.setupContent(element);
                    this.editMode = true;
                }else{
                    this.setupContent();
                }
            },
        /**
         * OKクリック時
         **/
            onOk : function()
            {
                var element = editor.document.createElement( 'img' );
                element.setAttribute( 'alt', '' );
                this.commitContent( element );
                $("#dialog").remove();
                $("#fileMenu").remove();
            },
            onCancel : function()
            {
                $("#dialog").remove();
                $("#fileMenu").remove();
            },
        /**
         * コンテンツ
         **/
            contents : [
                {
                    id : 'info',
                    label : 'イメージ情報',
                    title : 'イメージ情報',
                    elements :
                    [
                        {
                            id : 'imageList',
                            type : 'hbox',
                            padding : 0,
                            widths : [ '50%', '50%'],
                            children :
                            [
                                {   /* URL */
                                    id : 'txtUrl',
                                    type : 'text',
                                    label : 'URL',
                                    style:'margin-right : 10px;',
                                    setup : function(element)
                                    {
                                        if(element){
                                            this.setValue( decodeURI(element.getAttribute( 'src' )) );
                                        }
                                    },
                                    commit : function( element )
                                    {
                                        element.setAttribute('src', decodeURI(this.getValue()));
                                    }
                                },
                                {   /* alt */
                                    id : 'txtAlt',
                                    type : 'text',
                                    label : '説明文',
                                    style:'margin-right : 10px;',
                                    setup : function(element)
                                    {
                                        if(element){
                                            this.setValue( element.getAttribute( 'alt' ) );
                                        }
                                    },
                                    commit : function( element )
                                    {
                                        element.setAttribute('alt', this.getValue());
                                    }
                                }
                            ]
                        },
                        {
                            id : 'imageList2',
                            type : 'hbox',
                            padding : 0,
                            widths : [ '25%', '25%', '25%', '25%'],
                            children :
                            [
                                {   /* hspace */
                                    id : 'txtHspace',
                                    type : 'text',
                                    label : '横間隔',
                                    style:'margin-right : 10px;',
                                    setup : function(element)
                                    {
                                        if(element &&  element.getAttribute( 'hspace' )){
                                            this.setValue( element.getAttribute( 'hspace' ) );
                                        }else{
                                            this.setValue('10');
                                        }
                                    },
                                    commit : function( element )
                                    {
										var value = '0';
										if(this.getValue()){
											value = this.getValue();
										}
                                        element.setStyle('margin-left', value+'px');
                                        element.setStyle('margin-right', value+'px');
                                        element.setAttribute('hspace', value);
                                    }
                                },
                                {   /* vspace */
                                    id : 'txtVspace',
                                    type : 'text',
                                    label : '縦間隔',
                                    style:'margin-right : 10px;',
                                    setup : function(element)
                                    {
                                        if(element && element.getAttribute( 'vspace' )){
                                            this.setValue( element.getAttribute( 'vspace' ) );
                                        }else{
                                            this.setValue('0');
                                        }
                                    },
                                    commit : function( element )
                                    {
										var value = '0';
										if(this.getValue()){
											value = this.getValue();
										}
                                        element.setStyle('margin-top', value+'px');
                                        element.setStyle('margin-bottom', value+'px');
                                        element.setAttribute('vspace', value);
                                    }

                                },
                                {   /* align */
                                    id : 'cmbAlign',
                                    type : 'select',
                                    /*style : 'width:90px',*/
                                    label : editor.lang.image.align,
                                    'default' : '',
                                    items :
                                    [
                                        [ editor.lang.common.notSet , ''],
                                        [ editor.lang.image.alignLeft , 'left'],
                                        [ editor.lang.image.alignAbsBottom , 'absBottom'],
                                        [ editor.lang.image.alignAbsMiddle , 'absMiddle'],
                                        [ editor.lang.image.alignBaseline , 'baseline'],
                                        [ editor.lang.image.alignBottom , 'bottom'],
                                        [ editor.lang.image.alignMiddle , 'middle'],
                                        [ editor.lang.image.alignRight , 'right'],
                                        [ editor.lang.image.alignTextTop , 'textTop'],
                                        [ editor.lang.image.alignTop , 'top']
                                    ],
                                    setup : function( element )
                                    {
                                        if(element){
                                            this.setValue( element.getAttribute( 'align' ) );
                                        }
                                    },
                                    commit : function( element )
                                    {
                                        element.setAttribute( 'align', this.getValue());
                                    }
                                },
                                {   /* size */
                                    id : 'rdoSize',
                                    type : 'radio',
                                    label : 'サイズ',
                                    'default' : 'small',
                                    items :
                                    [
                                        [ '元サイズ' , ''],
                                        [ '小' , 'small'],
                                        [ '中' , 'midium'],
                                        [ '大' , 'large']
                                    ],
                                    setup : function( element )
                                    {
                                        var dialog = this.getDialog();
                                        var rdoSize = $("#"+this.domId);
                                        rdoSize.find('input[type=radio]').attr('disabled',true);
                                        rdoSize.find('input[type=radio]').eq(0).attr('disabled',false);

                                        rdoSize.find('input[type=radio]').click(function(){
											if($(this).attr('checked')){
 	                                           dialog.setValueOf('info','txtUrl',getFilePath(dialog.getValueOf('info','txtUrl'),dialog.getValueOf('info','rdoSize')));
											}
                                        });

                                        if(element){
                                            // 画像のサイズを取得する
                                            $.get(baseUrl+'admin/uploader/uploader_files/ajax_exists_images/'+getFileName(element.getAttribute( 'src' ),''),null,function(res){
                                                if(res){
                                                    rdoSize.find('input[type=radio]').eq(1).attr('disabled',!res.small);
                                                    rdoSize.find('input[type=radio]').eq(2).attr('disabled',!res.midium);
                                                    rdoSize.find('input[type=radio]').eq(3).attr('disabled',!res.large);
                                                }else{
                                                    rdoSize.find('input[type=radio]').attr('disabled',true);
                                                }
                                            },'json');
                                            this.setValue(getSizeByFile(element.getAttribute( 'src' )));
                                        }
                                    },
                                    commit : function( element )
                                    {
										var dialog = this.getDialog();
										var rdoSize = $("#"+this.domId);
						                if(!dialog.editMode){
											// リンク先用に最大サイズを取得
											var size = '';
											if(!rdoSize.find('input[type=radio]').eq(3).attr('disabled')){
												size = 'large';
											}else if(!rdoSize.find('input[type=radio]').eq(2).attr('disabled')){
												size = 'midium';
											}else if(!rdoSize.find('input[type=radio]').eq(1).attr('disabled')){
												size = 'small';
											}
											var src = getFilePath(element.getAttribute( 'src' ),size);
											linkElement = editor.document.createElement( 'a' );
											linkElement.setAttribute('href',src);
											linkElement.setAttribute('rel','colorbox');
											linkElement.setAttribute('title',element.getAttribute( 'alt' ));
											linkElement.append(element, false);
											editor.insertElement(linkElement);
										}else{
											editor.insertElement(element);
										}
                                    }
                                }
                            ]
                        },
                        {   /* fileManager */
                            id : 'fileManager',
                            type : 'vbox',
                            padding : 0,
                            children :
                            [],
                            setup : function()
                            {
                                var imageList = $("#"+this.domId);
                                imageList.css('width', 720);
                                imageList.css('height', 280);
                                imageList.html('<div style="text-align:center"><img src="'+baseUrl+'img/ajax-loader.gif" /></div>');
                                var dialog = this.getDialog();
                                $.ajax({
                                    type: "GET",
									dataType: "html",
                                    url: baseUrl+"admin/uploader/uploader_files/index/image?rand="+Math.floor(Math.random()*99999999+1),
                                    success: function(res){
										imageList.html(res);
                                        $("#fileList").bind('filelistload',function(){
                                            $('.selectable-file').click(function(){
                                                var img = $(this).children('img');
                                                var rdoSize = $("#"+dialog.getContentElement('info', 'rdoSize').domId);
                                                rdoSize.find('input[type=radio]').attr('disabled', true);
                                                rdoSize.find('input[type=radio]').eq(0).attr('disabled', false);
                                                if($(this).find('.small').html()){
                                                    rdoSize.find('input[type=radio]').eq(1).attr('checked', true);
                                                    rdoSize.find('input[type=radio]').eq(1).attr('disabled', false);

                                                }else{
                                                    rdoSize.find('input[type=radio]').eq(0).attr('checked', true);
                                                }
                                                if($(this).find('.midium').html()){
                                                    rdoSize.find('input[type=radio]').eq(2).attr('disabled', false);
                                                }
                                                if($(this).find('.large').html()){
                                                    rdoSize.find('input[type=radio]').eq(3).attr('disabled', false);
                                                }
                                                dialog.setValueOf('info','txtUrl',getFilePath($(this).children('img').attr('src'),dialog.getValueOf('info','rdoSize')));
                                                dialog.setValueOf( 'info', 'txtAlt' , $(this).find('.alt').html());
                                            });
											$(".selectable-file").unbind('dblclick.dblclickEvent');
                                            //$(".selectable-file").unbind('contextmenu');
                                        });
                                        $("#fileList").bind('deletecomplete',function(){
                                            dialog.setValueOf( 'info', 'txtUrl', '');
                                            dialog.setValueOf( 'info', 'txtAlt', '');
                                        });
                                    },
                                    error: function(msg,textStatus, errorThrown){
                                        alert(textStatus);
                                    }
                                });
                            }
                        }
                    ]
                }
            ]
        };
    });
}
/**
 * ファイル名を取得する
 */
function getFileName(url,size){

    var ret,dir,file,ext,fileName;
    ret = url.match(/([a-zA-Z0-9%_\-\(\)]*?)\.([a-zA-Z0-9]*?)$/);
    if(ret){
        file = decodeURI(ret[1].replace(/__[a-z]*?$/, ''));
        ext = ret[2];
        if(size){
            fileName = file + '__' + size + '.' + ext;
        }else{
            fileName = file + '.' + ext;
        }
        return fileName;
    }else{
        return url;
    }

}
/**
 * ファイルパスを取得する
 */
function getFilePath(url,size){
    var ret,fileName;
    fileName = getFileName(url,size);
    ret = url.match(/^(.*\/)([a-zA-Z0-9%_\-\(\)]*?)\.([a-zA-Z0-9]*?)$/);
    if(ret){
        return ret[1]+fileName;
    }else{
        return url;
    }
}
/**
 * ファイル名からファイルのサイズを取得
 */
function getSizeByFile(url){
    var ret = url.match(/__([a-z]*?)\.[a-zA-Z0-9]*?$/);
    if(ret){
        return ret[1];
    }else{
        return '';
    }
}