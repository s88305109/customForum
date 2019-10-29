<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<style>
table th, table td {
	background-color: #FFF;
	text-align: center;
    vertical-align: middle!important;
}
table th.left, table td.left {
	text-align: left;
}
tr.ui-sortable-helper, tr.ui-sortable-helper a {
    display: table;
    color: #FF0000;
}
tr.ui-sortable-helper td, tr.ui-sortable-helper th {
    background-color: #EEE;
    border: 1px dashed #fecccc;
}
.alert {
    display: none;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    $('.sortable').sortable({
    	cursor: 'move',
    	revert : true,
    	axis: 'y',
    	stop: function( event, ui ) {
            $(this).parents('div.row').find('button.updateSort').prop('disabled', false);
            $(this).parents('div.row').find('button.updateSort').removeClass('disabled');
    	}
    });
});

function updateSort() {
    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/updateBannerSort', $('#frm').serialize(), function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result).alert();
            $('.alert').fadeIn();
        } else {
            $('.alert .content').html('已成功儲存排序').alert();
            $('.alert').fadeIn();
        }
    });
}

function deleteBanner(id) {
    if (! confirm('是否確定要刪除？'))
        return false;

    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/deleteBanner', { bannerID : id }, function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result).alert();
            $('.alert').fadeIn();
        } else {
            $('#banner' + id).remove();
            $('.alert .content').html('已成功刪除').alert();
            $('.alert').fadeIn();
        }
    });
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
    	<nav aria-label="breadcrumb">
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page">管理後台 </li>
    			<li class="breadcrumb-item active" aria-current="page">橫幅廣告管理</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container admin">
	<div class="row">
        <div class="col-12 partition">
            <?php include('nav.php'); ?>
        </div>

        <div class="col-12">
    		<h3>
    			橫幅廣告管理
    			<small class="text-muted">首頁橫幅廣告的管理</small>
    		</h3>
        </div>

		<div class="col-12 text-right mb-1">
			<button type="button" class="btn btn-primary btn-sm disabled updateSort" onclick="updateSort();" disabled="disabled">儲存排序</button>
			<button type="button" class="btn btn-primary btn-sm active" onclick="window.location.href='<?=BASEPATH?>/admin/bannerEdit';">新增橫幅廣告</button>
		</div>

        <div class="col-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
            	<table class="table">
            		<thead class="thead-dark">
            			<tr>
            				<th scope="col">功能</th>
            				<th scope="col">標題</th>
            				<th scope="col">描述</th>
                            <th scope="col">圖片</th>
            				<th scope="col">狀態</th>
            			</tr>
            		</thead>

            		<tbody class="sortable">
            			<?php foreach((array)$banners as $row) : ?>
            			<tr id="banner<?=$row['bannerID']?>">
            				<th scope="row">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='<?=BASEPATH?>/admin/bannerEdit/<?=$row['bannerID']?>';" >設定</button> &nbsp; 
                                <button type="button" class="btn btn-danger" onclick="deleteBanner('<?=$row['bannerID']?>');" >刪除</button>
                                <input type="hidden" name="bannerID[]" value="<?=$row['bannerID']?>" />
                            </th>
            				<td class="left"><?=$row['title']?></td>
            				<td class="left"><?=$row['description']?></td>
                            <td>
                                <?php if (isset($row['filename']) && $row['filename'] != '') : ?>
                                <a href="<?=BASEPATH?>/upload/banner/<?=$row['filename']?>" target="_blank"><img src="<?=BASEPATH?>/upload/banner/<?=$row['filename']?>" width="200" />
                                <?php endif; ?>
                            </td>
            				<td><?=($row['status']) ? '<span class="text-success">啟用</span>' : '<span class="text-danger">停用</span>'?></td>
            			</tr>
            			<?php endforeach; ?>
            		</tbody>
            	</table>
            </form>
        </div>
    </div>   

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
