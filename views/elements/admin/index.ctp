<?php
/* SVN FILE: $Id$ */
/**
 * ファイル一覧
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
 * @package			uploader.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/* Ajaxで呼び出される事が前提の為インラインで呼びだし */
$baser->css('/js/jquery.contextMenu-1.0/jquery.contextMenu');
$baser->js(array('jquery.contextMenu-1.0/jquery.contextMenu','jquery.upload-1.0.0.min'));
?>
<script type="text/javascript">
	var baseUrl = '<?php echo $baser->root() ?>';
	$(function(){

		var allFields = $([]).add($("#name")).add($("#alt"));
		var tips = $("#validateTips");

		// 右クリックメニューをbodyに移動
		$("body").append($("#fileMenu"));

		// 一覧を更新する
		updateFileList();

		// ファイルアップロードイベントを登録
		$('#UploaderFileFile').change(uploaderFileFileChangeHandler);

		/* ダイアログを初期化 */
		$("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 500,
			width:400,
			modal: true,
			open: function(){
				var id = $("#fileList .selected .id").html();
				var name = $("#fileList .selected .name").html();
				var imgUrl = baseUrl+'admin/uploader/uploader_files/ajax_image/'+name+'/midium';
				$("#UploaderFileId").val($("#fileList .selected .id").html());
				$("#UploaderFileName").val(name);
				$("#UploaderFileAlt").val($("#fileList .selected .alt").html());
				$.get(imgUrl,function(res){
					$("#UploaderFileImage").html(res);
				});
			},
			buttons: {
				'キャンセル': function() {
					$(this).dialog('close');
					$("#UploaderFileImage").html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
				},
				'保存': function() {
					// 保存処理
					var saveButton = $(this);
					// IEでform.serializeを利用した場合、Formタグの中にTableタグがあるとデータが取得できなかった
					var data = {"data[UploaderFile][id]":$("#UploaderFileId").val(),
						"data[UploaderFile][name]":$("#UploaderFileName").val(),
						"data[UploaderFile][alt]":$("#UploaderFileAlt").val()};
					$.post($("#UploaderFileEditForm").attr('action'), data, function(res){
						if (res) {
							updateFileList();
							allFields.removeClass('ui-state-error');
							saveButton.dialog('close');
							$("#UploaderFileImage").html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
						} else {
							alert('更新に失敗しました');
						}
					});
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
				$("#UploaderFileImage").html('<img src="'+baseUrl+'img/ajax-loader.gif" />');
			}
		});
	});
	/**
	 * アップロードファイル選択時イベント
	 */
	function uploaderFileFileChangeHandler(){
		$("#waiting").show();
		if($('#UploaderFileFile').val()){
			var rand = Math.floor(Math.random()*99999999+1);
			$(this).upload(baseUrl+'admin/uploader/uploader_files/ajax_upload?rand='+rand, uploadSuccessHandler, 'html');
		}
	}
	/**
	 * アップロード完了後イベント
	 */
	function uploadSuccessHandler(res){
		if(res){
			//$(res).prependTo($("#fileList"));
			$("#fileList").html(res);
			initFileList();
		}else{
			$('#ErrorMessage').remove();
			$('#fileList').prepend('<p id="ErrorMessage" class="message">アップロードに失敗しました。ファイルサイズを確認してください。</p>');
		}
		// フォームを初期化
		// セキュリティ上の関係でvalue値を直接消去する事はできないので、一旦エレメントごと削除し、
		// spanタグ内に新しく作りなおす。
		$("#UploaderFileFile").remove();
		$("#SpanUploadFile").append('<input id="UploaderFileFile" type="file" value="" name="data[UploaderFile][file]"/>');
		$('#UploaderFileFile').change(uploaderFileFileChangeHandler);
		$("#waiting").hide();
	}
	/**
	 * 一覧を更新する
	 */
	function updateFileList(){
		$("#waiting").show();
		// リストを取得
		var rand = Math.floor(Math.random()*99999999+1);
<?php if($filter=='image'): ?>
			var url = baseUrl+'admin/uploader/uploader_files/ajax_list/image?rand='+rand
<?php else: ?>
			var url = baseUrl+'admin/uploader/uploader_files/ajax_list?rand='+rand
<?php endif ?>
			$.get(url,function(res){
				$("#fileList").html(res);
				initFileList();
				$("#waiting").hide();
			});
		}
		/**
		 * 選択イベントを初期化する
		 */
		function initFileList(){

			/* 一旦イベントを全て解除 */
			$(".selectable-file").unbind('click.selectEvent');
			$(".selectable-file").unbind('mouseenter.selectEvent');
			$(".selectable-file").unbind('mouseleave.selectEvent');
			$(".page-numbers a").unbind('click.paginationEvent');
			$(".selectable-file").unbind('dblclick.dblclickEvent');

			/* 右クリックメニューを追加 */
			if($(".selectable-file").contextMenu){
				$(".selectable-file").contextMenu({
					menu: 'fileMenu'
				},
				function(action, el, pos) {
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
								$.post(baseUrl+'admin/uploader/uploader_files/delete', {"data[UploaderFile][id]":$("#fileList .selected .id").html()}, function(res){
									if(!res){
										alert("サーバーでの処理に失敗しました。");
									}else{
										$("#fileList").trigger("deletecomplete");
										updateFileList();
									}
								});
							}
							break;
					}
				});
			}
			/* クリック時イベントを追加 */
			/*$(".selectable-file").bind('click.selectEvent', function(){
				$(".selectable-file").removeClass('selected');
				$(this).addClass('selected');
			});
			$('.selectable-file').bind('contextmenu.selectEvent',function(event){
				$(".selectable-file").removeClass('selected');
				$(this).addClass('selected');
			});*/
			// IEの場合contextmenuを検出できなかったので、mousedownに変更した
			$(".selectable-file").bind('mousedown', function(){
				$(".selectable-file").removeClass('selected');
				$(this).addClass('selected');
			});

			/* ホバー時イベントを追加 */
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
				$("#waiting").show();
				$.get($(this).attr('href'),function(res){
					$("#fileList").html(res);
					initFileList();
					$("#waiting").hide();
				});
				return false;
			});

			$('.selectable-file').corner("5px");
			$('.corner5').corner("5px");
			$("#fileList").trigger("filelistload");
			$("#fileList").effect("highlight",{},1500);

		}
		/**
		 * ダイアログのTipsを更新する
		 */
		function updateTips(t) {
			tips.text(t).effect("highlight",{},1500);
		}
</script>

<!-- コンテキストメニュー -->
<ul id="fileMenu" class="contextMenu">
    <li class="edit">
        <a href="#edit">編集</a>
    </li>
    <li class="delete">
        <a href="#delete">削除</a>
    </li>
</ul>

<?php if(!$installMessage): ?>
<p><label for="UploaderFileFile">アップロード</label><br />
	<span id="SpanUploadFile"><?php echo $form->file('UploaderFile.file') ?></span></p>
<?php else: ?>
<p style="color:#C00;font-weight:bold"><?php echo $installMessage ?></p>
<?php endif ?>

<!-- ファイルリスト -->
<div id="fileList" class="corner5">
</div>
<div id="waiting" class="corner5">
	<?php echo $html->image('ajax-loader.gif') ?>
    Waiting...
</div>


<!-- 編集ダイアログ -->
<div id="dialog" title="ファイル情報編集">
    <!--<p id="validateTips"><small><span class="required">*</span> 印の項目は必須です。</small></p>-->
	<?php echo $form->create('UploaderFile',array('action'=>'edit')) ?>
    <table cellpadding="0" cellspacing="0" class="frmTbl01">
        <tr>
            <th class="col-head"><?php echo $form->label('UploaderFile.id', 'NO') ?></th>
            <td class="col-input">
				<?php echo $form->text('UploaderFile.id', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly')) ?>&nbsp;
            </td>
        </tr>
		<tr>
			<th class="col-head"><!--<span class="required">*</span>&nbsp;--><?php echo $form->label('UploaderFile.name', 'ファイル名') ?></th>
			<td class="col-input">
				<?php echo $form->text('UploaderFile.name', array('size'=>30,'maxlength'=>255,'readonly'=>'readonly')) ?>
				<?php echo $form->error('UploaderFile.name', '>> ファイル名を入力して下さい') ?>&nbsp;
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $form->label('UploaderFile.real_name_1', '説明文') ?></th>
			<td class="col-input">
				<?php echo $form->text('UploaderFile.alt', array('size'=>30,'maxlength'=>255)) ?>&nbsp;
			</td>
		</tr>
		<tr><td colspan="2" id="UploaderFileImage"><?php echo $html->image('ajax-loader.gif') ?></td></tr>
    </table>
</form>
</div>