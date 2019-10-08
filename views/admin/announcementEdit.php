<style>
.alert {
    display: none;
}
</style>
<script type="text/javascript">
function saveSetting() {
    $('.alert').hide();

    var formData = new FormData($('#frm')[0]);  

    $.ajax({  
        url: '<?=BASEPATH?>/admin/announcementSave' ,  
        type: 'POST',  
        data: formData,  
        async: false,  
        cache: false,  
        contentType: false,  
        processData: false,  
        success: function (result) {  
            if (result != 'OK') {
                $('.alert .content').html(result).alert();
                $('.alert').fadeIn();
            } else {
                window.location.href = '<?=BASEPATH?>/admin/announcementManage';
            }
        },  
        error: function (result) {  
            $('.alert .content').html(result).alert();
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
    			<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
    			<li class="breadcrumb-item active" aria-current="page">公告管理</li>
                <li class="breadcrumb-item active" aria-current="page">頁首公告設定</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container">
    <div class="row news">
		<h3>頁首公告設定</h3>

        <div class="col-md-12 col-sm-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
                <input type="hidden" name="announcementID" value="<?=$announcementID?>" />

                <div class="form-group">
                    <label for="title">公告標題</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=(isset($announcement['title'])) ? $announcement['title'] : ''?>" />
                </div>

                <div class="form-group">
                    <label for="link">超連結</label>
                    <input type="text" class="form-control" id="link" name="link" value="<?=(isset($announcement['link'])) ? $announcement['link'] : ''?>" />
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="startTime">開始時間</label>
                            <input type="text" class="form-control input-group" id="startTime" name="startTime" value="<?=(isset($announcement['startTime'])) ? $announcement['startTime'] : ''?>" placeholder="e.g. 2019-01-01 10:00:00" />
                        </div>
                        <div class="col">
                            <label for="endTime">結束時間</label>
                            <input type="text" class="form-control input-group" id="endTime" name="endTime" value="<?=(isset($announcement['endTime'])) ? $announcement['endTime'] : ''?>" placeholder="e.g. 2019-01-01 23:59:59" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mr-4">狀態　　　</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status0" name="status" value="0" <?php if (! isset($announcement['status']) || $announcement['status'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status0">停用</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status1" name="status" value="1" <?php if (isset($announcement['status']) && $announcement['status'] == 1) echo 'checked="checked"'; ?> />
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
