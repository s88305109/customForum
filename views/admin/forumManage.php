<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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

function updateSort(frmName) {
    $('.' + frmName + 'alert').hide();

    if (frmName == 'frm1')
        var action = 'updateCategorySort';
    else
        var action = 'updateBoardSort';

    $.post('<?=BASEPATH?>/admin/' + action, $('#' + frmName).serialize(), function(result) {
        if (result != 'OK') {
            $('.' + frmName + 'Alert .content').html(result).alert();
            $('.' + frmName + 'Alert').fadeIn();
        } else {
            $('.' + frmName + 'Alert .content').html('已成功儲存排序').alert();
            $('.' + frmName + 'Alert').fadeIn();
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
                <li class="breadcrumb-item active" aria-current="page">版面管理 </li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container admin">
	<div class="row">
        <div class="col-12 partition">
            <ul class="nav">
                <li class="active">
                    <a href="<?=BASEPATH?>/admin/forumManage">版面管理</a>
                </li>
                <li>
                    <a href="<?=BASEPATH?>/admin/bannerManage">橫幅廣告管理</a>
                </li>
                <li>
                    <a href="<?=BASEPATH?>/admin/announcementManage">公告管理</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
    		<h3>
    			版面管理
    			<small class="text-muted">討論區分類的管理</small>
    		</h3>
        </div>

		<div class="col-12 text-right mb-1">
			<button type="button" class="btn btn-primary btn-sm disabled updateSort" onclick="updateSort('frm1');" disabled="disabled">儲存排序</button>
			<button type="button" class="btn btn-primary btn-sm active" onclick="window.location.href='<?=BASEPATH?>/admin/categoryManage';">新增分類</button>
		</div>

        <div class="col-12">
            <div class="frm1Alert alert alert-warning">
                <a href="#" class="close" onclick="$('.frm1Alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm1">
            	<table class="table">
            		<thead class="thead-dark">
            			<tr>
            				<th scope="col">功能</th>
            				<th scope="col">分類標題</th>
            				<th scope="col">描述</th>
                            <th scope="col">顯示</th>
            				<th scope="col">狀態</th>
            			</tr>
            		</thead>

            		<tbody class="sortable">
            			<?php foreach((array)$categoryData as $row) : ?>
            			<tr>
            				<th scope="row">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='<?=BASEPATH?>/admin/categoryManage/<?=$row['categoryID']?>';" >設定</button>
                                <input type="hidden" name="categoryID[]" value="<?=$row['categoryID']?>" />
                            </th>
            				<td class="left"><?=$row['title']?></td>
            				<td class="left"><?=$row['description']?></td>
                            <td><?=($row['visible']) ? '<span class="text-success">顯示</span>' : '<span class="text-danger">隱藏</span>'?></td>
            				<td><?=($row['status']) ? '<span class="text-success">啟用</span>' : '<span class="text-danger">停用</span>'?></td>
            			</tr>
            			<?php endforeach; ?>
            		</tbody>
            	</table>
            </form>
        </div>
    </div>

    <hr />

	<div class="row news">
		<h3>
			看板列表
			<small class="text-muted">討論區看板的管理</small>
		</h3>
			
		<div class="col-md-12 col-sm-12 text-right mb-1">
			<button type="button" class="btn btn-primary btn-sm disabled updateSort" onclick="updateSort('frm2');" disabled="disabled">儲存排序</button>
			<button type="button" class="btn btn-primary btn-sm active" onclick="window.location.href='<?=BASEPATH?>/admin/boardManage';">新增看板</button>
		</div>

        <div class="col-md-12 col-sm-12">
            <div class="frm2Alert alert alert-warning">
                <a href="#" class="close" onclick="$('.frm2Alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm2">
            	<table class="table">
            		<thead class="thead-dark">
            			<tr>
            				<th scope="col">功能</th>
            				<th scope="col">分類</th>
            				<th scope="col">看板標題</th>
            				<th scope="col">描述</th>
                            <th scope="col">顯示</th>
            				<th scope="col">狀態</th>
            			</tr>
            		</thead>

    				<?php
    				$currentCategoryID = NULL;
    				foreach((array)$boardData as $row) :
    				?>

    				<?php if ($currentCategoryID != NULL && $currentCategoryID != $row['categoryID']) : ?>
            		</tbody>
            		<?php endif; ?>

    				<?php if ($currentCategoryID != $row['categoryID']) : ?>
            		<tbody class="sortable">
            		<?php endif; ?>

            			<tr>
            				<th scope="row">
                                <button type="button" class="btn btn-primary" onclick="window.location.href='<?=BASEPATH?>/admin/boardManage/<?=$row['boardID']?>';" >設定</button>
                                <input type="hidden" name="boardID[]" value="<?=$row['boardID']?>" />
                            </th>
            				<td class="left"><?=$row['categoryTitle']?></td>
            				<td class="left"><a href="<?=BASEPATH?>/board/c<?=$row['categoryID']?>/b<?=$row['boardID']?>" target="_blank"><?=$row['title']?></a></td>
            				<td class="left"><?=$row['description']?></td>
                            <td><?=($row['visible']) ? '<span class="text-success">顯示</span>' : '<span class="text-danger">隱藏</span>'?></td>
            				<td><?=($row['status']) ? '<span class="text-success">啟用</span>' : '<span class="text-danger">停用</span>'?></td>
            			</tr>

            		<?php
            			$currentCategoryID = $row['categoryID'];
            		endforeach;
            		?>
            	</table>
            </form>
        </div>
    </div>    

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
