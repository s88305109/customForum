<style>
.alert {
    display: none;
}
</style>
<script type="text/javascript">
function saveSetting() {
    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/boardSave', $('#frm').serialize(), function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result).alert();
            $('.alert').fadeIn();
        } else {
            window.location.href = '<?=BASEPATH?>/admin/forumManage';
        }
    });
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
    	<nav aria-label="breadcrumb">
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
    			<li class="breadcrumb-item active" aria-current="page">版面管理</li>
                <li class="breadcrumb-item active" aria-current="page">看板設定</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container">
    <div class="row news">
		<h3>看板設定</h3>

        <div class="col-md-12 col-sm-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
                <input type="hidden" name="boardID" value="<?=$boardID?>" />

                <div class="form-group">
                    <label for="categoryID">分類</label>
                    <select class="form-control" id="categoryID" name="categoryID">
                        <option></option>
                        <?php 
                        foreach((array)$categoryData as $row) {
                            echo (isset($board['categoryID']) && $board['categoryID'] == $row['categoryID']) ? "<option value=\"{$row['categoryID']}\" selected=\"selected\">{$row['title']}</option>" : "<option value=\"{$row['categoryID']}\">{$row['title']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">看板標題</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=(isset($board['title'])) ? $board['title'] : ''?>" />
                </div>

                <div class="form-group">
                    <label for="description">描述</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?=(isset($board['description'])) ? $board['description'] : ''?></textarea>
                </div>

                <div class="form-group">
                    <label class="mr-4">顯示於列表</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="visible0" name="visible" value="0" <?php if (! isset($board['visible']) || $board['visible'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="visible0">隱藏</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="visible1" name="visible" value="1" <?php if (isset($board['visible']) && $board['visible'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="visible1">顯示</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mr-4">高亮顯示　</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="highlight0" name="highlight" value="0" <?php if (! isset($board['highlight']) || $board['highlight'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="highlight0">否　</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="highlight1" name="highlight" value="1" <?php if (isset($board['highlight']) && $board['highlight'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="highlight1">是　</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mr-4">狀態　　　</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status0" name="status" value="0" <?php if (! isset($board['status']) || $board['status'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status0">停用</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status1" name="status" value="1" <?php if (isset($board['status']) && $board['status'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status1">啟用</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-12 col-sm-12 text-center mb-1">
            <button type="button" class="btn btn-primary active" onclick="saveSetting();">儲存</button>
        </div>
    </div>    

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
