/**
 * 起動時処理
 */
$(function(){

	var listId = $("#ListId").html();
	var allFields = $([]).add($("#name")).add($("#alt"));
	var baseUrl = $("#BaseUrl").html();

	// 右クリックメニューをbodyに移動
	$("body").append($("#FileMenu1"));
	$("body").append($("#FileMenu2"));

	// 一覧を更新する
	updateFileList();

	// ファイルアップロードイベントを登録
	$('#UploaderFileFile'+listId).change(uploaderFileFileChangeHandler);

	/* ダイアログを初期化 */
	$("#dialog").dialog({
		bgiframe: true,
		autoOpen: false,
		position: ['center', 20],
		width:480,
		modal: true,
		open: function(){
			var name = $("#fileList"+listId+" .selected .name").html();
			var imgUrl = baseUrl+'admin/uploader/uploader_files/ajax_image/'+name+'/midium';
			$("#UploaderFileId"+listId).val($("#fileList" + $("#ListId").html() + " .selected .id").html());
			$("#UploaderFileName"+listId).val(name);
			$("#UploaderFileAlt"+listId).val($("#fileList"+listId+" .selected .alt").html());
			$("#UploaderFileUserId"+listId).val($("#fileList"+listId+" .selected .user-id").html());
			$("#UploaderFileUserName"+listId).html($("#fileList"+listId+" .selected .user-name").html());
			if($("#_UploaderFileUploaderCategoryId"+listId).length) {
				$("#_UploaderFileUploaderCategoryId"+listId).val($("#fileList"+listId+" .selected .uploader-category-id").html());
			}

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
					"data[UploaderFile][alt]":$("#UploaderFileAlt"+listId).val(),
					"data[UploaderFile][user_id]":$("#UploaderFileUserId"+listId).val(),
					"data[UploaderFile][uploader_category_id]":$("#_UploaderFileUploaderCategoryId"+listId).val()
				};
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
	var url = $("#BaseUrl").html()+'admin/uploader/uploader_files/ajax_upload';
	$("#Waiting").show();
	if($('#UploaderFileFile'+listId).val()){
		var data = [];
		if($("#UploaderFileUploaderCategoryId"+listId).length) {
			data = {'data[UploaderFile][uploader_category_id]':$("#UploaderFileUploaderCategoryId"+listId).val()};
		}
		$(this).upload(url, data, uploadSuccessHandler, 'html');
	}

}
/**
 * アップロード完了後イベント
 */
function uploadSuccessHandler(res){

	var listId = $("#ListId").html();
	if(res){
		if($('#UploaderFileUploaderCategoryId'+listId).length) {
			$('#FilterUploaderCategoryId'+listId).val($('#UploaderFileUploaderCategoryId'+listId).val());
		}
		updateFileList();
	}else{
		$('#ErrorMessage').remove();
		$('#fileList'+listId).prepend('<p id="ErrorMessage" class="message">アップロードに失敗しました。ファイルサイズを確認してください。</p>');
		$("#Waiting").hide();
	}
	// フォームを初期化
	// セキュリティ上の関係でvalue値を直接消去する事はできないので、一旦エレメントごと削除し、
	// spanタグ内に新しく作りなおす。
	$("#UploaderFileFile"+listId).remove();
	$("#SpanUploadFile"+listId).append('<input id="UploaderFileFile'+listId+'" type="file" value="" name="data[UploaderFile][file]" class="uploader-file-file" />');
	$('#UploaderFileFile'+listId).change(uploaderFileFileChangeHandler);

}
/**
 * 一覧を更新する
 */
function updateFileList(){

	$("#Waiting").show();
	$.get(getListUrl(),updateFileListCompleteHander);

}
/**
 * 選択イベントを初期化する
 */
function initFileList(){

	var listId = $("#ListId").html();
	var usePermission = $("#UsePermission").html();

	/* 一旦イベントを全て解除 */
	$(".selectable-file").unbind('click.selectEvent');
	$(".selectable-file").unbind('mouseenter.selectEvent');
	$(".selectable-file").unbind('mouseleave.selectEvent');
	$(".page-numbers a").unbind('click.paginationEvent');
	$(".selectable-file").unbind('dblclick.dblclickEvent');
	$(".filter-control").unbind('change.filterEvent');

	$(".selectable-file").each(function(){
		if($(this).contextMenu && !listId) {
			/* 右クリックメニューを追加 */
			if($(this).find('.user-id').html() == $("#LoginUserId").html() || $("#LoginUserGroupId").html() == 1 || !Number(usePermission)) {
				$(this).contextMenu({menu: 'FileMenu1'}, contextMenuHander);
				$(this).bind('dblclick.dblclickEvent', function(){
					$('#dialog').dialog('open');
				});
			} else {
				$(this).contextMenu({menu: 'FileMenu2'}, contextMenuHander);
				$(this).bind('dblclick.dblclickEvent', function(){
					alert('このファイルの編集・削除はできません。');
				});
			}
		} else {
			$(this).bind("contextmenu",function(e){
				return false;
			});
		}

		// IEの場合contextmenuを検出できなかったので、mousedownに変更した
		$(this).bind('mousedown', function(){
			$(".selectable-file").removeClass('selected');
			$(this).addClass('selected');
		});

	});

	$(".selectable-file").bind('mouseenter.selectEvent', function(){
		$(this).css('background-color','#FFCC00');
	});
	$(".selectable-file").bind('mouseleave.selectEvent', function(){
		$(this).css('background-color','#FFFFFF');
	});

	/* ページネーションイベントを追加 */
	$('.page-numbers a').bind('click.paginationEvent', function(){
		$("#Waiting").show();
		$.get($(this).attr('href'),updateFileListCompleteHander);
		return false;
	});

	$("#BtnFilter"+listId).bind('click.filterEvent', function(){
		$("#Waiting").show();
		$.get(getListUrl(),updateFileListCompleteHander);			
	});
/*		$('#FilterUploaderCategoryId'+listId).bind('change.filterEvent', function() {
		$("#Waiting").show();
		$.get(getListUrl(),updateFileListCompleteHander);
	});
	$('input[name="data[Filter][uploader_type]"]').bind('click.filterEvent', function() {
		$("#Waiting").show();
		$.get(getListUrl(),updateFileListCompleteHander);
	});*/

	$('.selectable-file').corner("5px");
	$('.corner5').corner("5px");
	$("#fileList"+listId).trigger("filelistload");
	$("#fileList"+listId).effect("highlight",{},1500);

}
/**
 * ファイルリスト取得完了イベント
 */
function updateFileListCompleteHander(result) {
	
	var listId = $("#ListId").html();
	$("#fileList"+listId).html(result);
	initFileList();
	$("#Waiting").hide();
	
}
/**
 * Ajax List 取得用のURLを取得する
 */
function getListUrl() {
	
	var listId = $("#ListId").html();
	var listUrl = $("#ListUrl"+listId).attr('href');
	if($('#FilterUploaderCategoryId'+listId).length) {
		listUrl += '/uploader_category_id:'+$('#FilterUploaderCategoryId'+listId).val();
	}
	if($('input[name="data[Filter][uploader_type]"]:checked').length) {
		listUrl += '/uploader_type:'+$('input[name="data[Filter][uploader_type]"]:checked').val();
	}
	if($('#FilterName'+listId).length) {
		listUrl += '/name:'+ encodeURI($('#FilterName'+listId).val());
	}
	p(listUrl);
	return listUrl;
	
}
/**
 * コンテキストメニューハンドラ
 */
function contextMenuHander(action, el, pos) {

	var listId = $("#ListId").html();
	var delUrl = $("#BaseUrl").html()+'admin/uploader/uploader_files/delete';

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
				$("#Waiting").show();
				$.post(delUrl, {"data[UploaderFile][id]": $("#fileList"+listId+" .selected .id").html()}, function(res){
					if(!res){
						$("#Waiting").hide();
						alert("サーバーでの処理に失敗しました。");
					}else{
						$("#fileList"+listId).trigger("deletecomplete");
						updateFileList();
					}
				});
			}
			break;
	}
	
}