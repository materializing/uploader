<?php
/* SVN FILE: $Id$ */
/**
 * [ADMIN] ファイル一覧
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
if(!isset($listId)) {
	$listId = '';
}
//==============================================================================
// Ajaxで呼び出される事が前提の為インラインで呼びだし
//==============================================================================
$baser->css('/js/jquery.contextMenu-1.0/jquery.contextMenu');
$baser->js(array('jquery.contextMenu-1.0/jquery.contextMenu', 'jquery.upload-1.0.0.min'));
?>
<script type="text/javascript">
/**
 * 起動時処理
 */
	$(function(){

		var allFields = $([]).add($("#name")).add($("#alt"));
		var listId = $("#ListId").html();
		var baseUrl = $("#BaseUrl").html();
		
		// 右クリックメニューをbodyに移動
		$("body").append($("#fileMenu"));

		// 一覧を更新する
		updateFileList();

		// ファイルアップロードイベントを登録
		$('#UploaderFileFile'+listId).change(uploaderFileFileChangeHandler);

		/* ダイアログを初期化 */
		$("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			position: ['center', 20],
			width:420,
			modal: true,
			open: function(){
				var name = $("#fileList"+listId+" .selected .name").html();
				var imgUrl = baseUrl+'admin/uploader/uploader_files/ajax_image/'+name+'/midium';
				$("#UploaderFileId"+listId).val($("#fileList<?php echo $listId ?> .selected .id").html());
				$("#UploaderFileName"+listId).val(name);
				$("#UploaderFileAlt"+listId).val($("#fileList"+listId+" .selected .alt").html());
				$.get(imgUrl,function(res){
					$("#UploaderFileImage"+listId).html(res);
				});
			},
			buttons: {
				'キャンセル': function() {
					$(this).dialog('close');
					$("#UploaderFileImage"+listId).html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
				},
				'保存': function() {
					// 保存処理
					var saveButton = $(this);
					// IEでform.serializeを利用した場合、Formタグの中にTableタグがあるとデータが取得できなかった
					var data = {"data[UploaderFile][id]":$("#UploaderFileId"+listId).val(),
						"data[UploaderFile][name]":$("#UploaderFileName"+listId).val(),
						"data[UploaderFile][alt]":$("#UploaderFileAlt"+listId).val()};
					$.post($("#UploaderFileEditForm"+listId).attr('action'), data, function(res){
						if (res) {
							updateFileList();
							allFields.removeClass('ui-state-error');
							saveButton.dialog('close');
							$("#UploaderFileImage"+listId).html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
						} else {
							alert('更新に失敗しました');
						}
					});
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
				$("#UploaderFileImage"+listId).html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
			}
			
		});

	});
/**
 * アップロードファイル選択時イベント
 */
	function uploaderFileFileChangeHandler(){
	
		var listId = $("#ListId").html();
		var url = $("#BaseUrl").html()+'admin/uploader/uploader_files/ajax_upload?rand='+rand;
		$("#waiting"+listId).show();
		if($('#UploaderFileFile'+listId).val()){
			var rand = Math.floor(Math.random()*99999999+1);
			$(this).upload(url, uploadSuccessHandler, 'html');
		}
		
	}
/**
 * アップロード完了後イベント
 */
	function uploadSuccessHandler(res){
		
		var listId = $("#ListId").html();
		if(res){
			$("#fileList"+listId).html(res);
			initFileList();
		}else{
			$('#ErrorMessage').remove();
			$('#fileList'+listId).prepend('<p id="ErrorMessage" class="message">アップロードに失敗しました。ファイルサイズを確認してください。</p>');
		}
		// フォームを初期化
		// セキュリティ上の関係でvalue値を直接消去する事はできないので、一旦エレメントごと削除し、
		// spanタグ内に新しく作りなおす。
		$("#UploaderFileFile"+listId).remove();
		$("#SpanUploadFile"+listId).append('<input id="UploaderFileFile'+listId+'" type="file" value="" name="data[UploaderFile][file]"/>');
		$('#UploaderFileFile'+listId).change(uploaderFileFileChangeHandler);
		$("#waiting"+listId).hide();
	}
/**
 * 一覧を更新する
 */
	function updateFileList(){

		var listId = $("#ListId").html();
		var url = $("#BaseUrl").html()+'admin/uploader/uploader_files/ajax_list/'+Math.floor(Math.random()*99999999+1);

		if($("#Filter").html() == 'image') {
			url += '/image';
		}
		if($("#Num").html()) {
			url += '/num:'+$("#Num").html();
		}

		$("#waiting"+listId).show();
		$.get(url,function(res){
			$("#fileList"+listId).html(res);
			initFileList();
			$("#waiting"+listId).hide();
		});

	}
/**
 * 選択イベントを初期化する
 */
	function initFileList(){

		var listId = $("#ListId").html();
		var delUrl = $("#BaseUrl").html()+'admin/uploader/uploader_files/delete';
		
		/* 一旦イベントを全て解除 */
		$(".selectable-file").unbind('click.selectEvent');
		$(".selectable-file").unbind('mouseenter.selectEvent');
		$(".selectable-file").unbind('mouseleave.selectEvent');
		$(".page-numbers a").unbind('click.paginationEvent');
		$(".selectable-file").unbind('dblclick.dblclickEvent');

		/* 右クリックメニューを追加 */
		if($(".selectable-file").contextMenu){
			
			$(".selectable-file").contextMenu({menu: 'fileMenu'}, function(action, el, pos) {
				
				// IEの場合、action値が正常に取得できないので整形する
				var pos = action.indexOf("#");
				
				if(pos != -1){
					action = action.substring(pos+1,action.length);
				}
				
				switch (action){
					
					case 'edit':
						$('#dialog').dialog('open');
						break;
						
					case 'delete':
						if(confirm('本当に削除してもよろしいですか？')){
							$.post(delUrl, {"data[UploaderFile][id]": $("#fileList"+listId+" .selected .id").html()}, function(res){
								if(!res){
									alert("サーバーでの処理に失敗しました。");
								}else{
									$("#fileList"+listId).trigger("deletecomplete");
									updateFileList();
								}
							});
						}
						break;
				}
				
			});
			
		}

		// IEの場合contextmenuを検出できなかったので、mousedownに変更した
		$(".selectable-file").bind('mousedown', function(){
			$(".selectable-file").removeClass('selected');
			$(this).addClass('selected');
		});
		$(".selectable-file").bind('mouseenter.selectEvent', function(){
			$(this).css('background-color','#FFCC00');
		});
		$(".selectable-file").bind('mouseleave.selectEvent', function(){
			$(this).css('background-color','#FFFFFF');
		});
		$(".selectable-file").bind('dblclick.dblclickEvent', function(){
			$('#dialog').dialog('open');
		});

		/* ページネーションイベントを追加 */
		$('.page-numbers a').bind('click.paginationEvent', function(){
			$("#waiting"+listId).show();
			$.get($(this).attr('href'),function(res){
				$("#fileList"+listId).html(res);
				initFileList();
				$("#waiting"+listId).hide();
			});
			return false;
		});

		$('.selectable-file').corner("5px");
		$('.corner5').corner("5px");
		$("#fileList"+listId).trigger("filelistload");
		$("#fileList"+listId).effect("highlight",{},1500);

	}
</script>

<!-- BaseUrl -->
<div id="BaseUrl" style="display: none"><?php echo $baser->root() ?></div>

<!-- ListId -->
<div id="ListId" style="display: none"><?php echo $listId ?></div>

<!-- Filter -->
<div id="Filter" style="display: none"><?php echo $filter ?></div>

<!-- Num -->
<div id="Num" style="display: none"><?php echo $this->passedArgs['num'] ?></div>

<!-- コンテキストメニュー -->
<ul id="fileMenu" class="contextMenu">
    <li class="edit">
        <a href="#edit">編集</a>
    </li>
    <li class="delete">
        <a href="#delete">削除</a>
    </li>
</ul>

<!-- loader -->
<div id="waiting<?php echo $listId ?>" class="waiting corner5">
	<?php echo $html->image('ajax-loader.gif') ?>
    Waiting...
</div>

<!-- 編集ダイアログ -->
<div id="dialog" title="ファイル情報編集">
	<?php echo $form->create('UploaderFile',array('action' => 'edit', 'id' => 'UploaderFileEditForm'.$listId)) ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th class="col-head"><?php echo $form->label('UploaderFile.id', 'NO') ?></th>
            <td class="col-input">
				<?php echo $form->text('UploaderFile.id', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileId'.$listId, 'class' => 'uploader-file-id')) ?>&nbsp;
            </td>
        </tr>
		<tr>
			<th class="col-head"><!--<span class="required">*</span>&nbsp;--><?php echo $form->label('UploaderFile.name', 'ファイル名') ?></th>
			<td class="col-input">
				<?php echo $form->text('UploaderFile.name', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly','id'=>'UploaderFileName'.$listId, 'class' => 'uploader-file-name')) ?>
				<?php echo $form->error('UploaderFile.name', 'ファイル名を入力して下さい') ?>&nbsp;
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $form->label('UploaderFile.real_name_1', '説明文') ?></th>
			<td class="col-input">
				<?php echo $form->text('UploaderFile.alt', array('size'=>30,'maxlength'=>255,'id'=>'UploaderFileAlt'.$listId)) ?>&nbsp;
			</td>
		</tr>
		<tr><td colspan="2" id="UploaderFileImage<?php echo $listId ?>" class="uploader-file-image"><?php echo $html->image('ajax-loader.gif') ?></td></tr>
    </table>
	<?php echo $form->end() ?>
</div>

<!-- form -->
<?php if(!$installMessage): ?>
<p><label for="UploaderFileFile<?php echo $listId ?>">アップロード</label><br />
	<span id="SpanUploadFile<?php echo $listId ?>"><?php echo $form->file('UploaderFile.file', array('id'=>'UploaderFileFile'.$listId, 'class' => 'uploader-file-file')) ?></span></p>
<?php else: ?>
<p style="color:#C00;font-weight:bold"><?php echo $installMessage ?></p>
<?php endif ?>

<!-- list-num -->
<?php if(empty($this->params['isAjax'])): ?>
<?php $baser->element('list_num') ?>
<?php endif ?>

<!-- ファイルリスト -->
<div id="fileList<?php echo $listId ?>" class="corner5 file-list"></div>