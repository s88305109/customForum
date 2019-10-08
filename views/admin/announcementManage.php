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
function deleteAnnouncement(id) {
    if (! confirm('是否確定要刪除？'))
        return false;

    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/deleteAnnouncement', { announcementID : id }, function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result).alert();
            $('.alert').fadeIn();
        } else {
            $('#announcement' + id).remove();
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
    			<li class="breadcrumb-item active" aria-current="page">公告管理</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container admin">
	<div class="row">
        <div class="col-12 partition">
            <ul class="nav">
                <li>
                    <a href="<?=BASEPATH?>/admin/forumManage">版面管理</a>
                </li>
                <li>
                    <a href="<?=BASEPATH?>/admin/bannerManage">橫幅廣告管理</a>
                </li>
                <li  class="active">
                    <a href="<?=BASEPATH?>/admin/announcementManage">公告管理</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
    		<h3>
    			公告管理
    			<small class="text-muted">頁首公告的管理</small>
    		</h3>
        </div>

		<div class="col-12 text-right mb-1">
			<button type="button" class="btn btn-primary btn-sm active" onclick="window.location.href='<?=BASEPATH?>/admin/announcementEdit';">新增頁首公告</button>
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
                            <th scope="col">公告時間</th>
            				<th scope="col">狀態</th>
            			</tr>
            		</thead>

            		<tbody class="sortable">
            			<?php foreach((array)$announcements as $row) : ?>
            			<tr id="announcement<?=$row['announcementID']?>">
            				<th scope="row">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='<?=BASEPATH?>/admin/announcementEdit/<?=$row['announcementID']?>';" >設定</button> &nbsp; 
                                <button type="button" class="btn btn-danger" onclick="deleteAnnouncement('<?=$row['announcementID']?>');" >刪除</button>
                                <input type="hidden" name="announcementID[]" value="<?=$row['announcementID']?>" />
                            </th>
            				<td><?=$row['title']?></td>
                            <td><?=$row['startTime']?> ~ <?=$row['endTime']?></td>
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
