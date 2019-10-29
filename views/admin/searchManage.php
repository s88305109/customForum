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
function deleteSearch(id) {
    if (! confirm('是否確定要刪除？'))
        return false;

    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/deleteSearch', { searchID : id }, function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result).alert();
            $('.alert').fadeIn();
        } else {
            $('#search' + id).remove();
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
    			<li class="breadcrumb-item active" aria-current="page">熱搜管理</li>
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
    			熱搜管理
    			<small class="text-muted">熱搜項目的管理</small>
    		</h3>
        </div>

        <div class="col-12 mt-1">
            <p class="text-primary">熱搜顯示將自動搜尋30天內有搜尋紀錄且累計次數最多的前20筆隨機顯示</p>
        </div>

		<div class="col-12 text-right mb-1">
			<button type="button" class="btn btn-primary btn-sm active" onclick="window.location.href='<?=BASEPATH?>/admin/searchEdit';">新增熱搜項目</button>
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
            				<th scope="col">熱搜內容</th>
                            <th scope="col">搜尋次數</th>
            				<th scope="col">最後搜尋時間</th>
            			</tr>
            		</thead>

            		<tbody class="sortable">
            			<?php foreach((array)$searches as $row) : ?>
            			<tr id="search<?=$row['searchID']?>">
            				<th scope="row">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='<?=BASEPATH?>/admin/searchEdit/<?=$row['searchID']?>';" >設定</button> &nbsp; 
                                <button type="button" class="btn btn-danger" onclick="deleteSearch('<?=$row['searchID']?>');" >刪除</button>
                                <input type="hidden" name="searchID[]" value="<?=$row['searchID']?>" />
                            </th>
            				<td><a href="<?=BASEPATH?>/search/<?=$row['searchstr']?>" target="_blank"><?=$row['searchstr']?></a></td>
                            <td><?=$row['count']?></td>
            				<td><?=$row['lastSearchTime']?></td>
            			</tr>
            			<?php endforeach; ?>
            		</tbody>
            	</table>
            </form>
        </div>
    </div>   

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
