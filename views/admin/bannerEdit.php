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
        url: '<?=BASEPATH?>/admin/bannerSave' ,  
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
                window.location.href = '<?=BASEPATH?>/admin/bannerManage';
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
    			<li class="breadcrumb-item active" aria-current="page">橫幅廣告管理</li>
                <li class="breadcrumb-item active" aria-current="page">廣告設定</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container">
    <div class="row news">
		<h3>廣告設定</h3>

        <div class="col-md-12 col-sm-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
                <input type="hidden" name="bannerID" value="<?=$bannerID?>" />

                <div class="form-group">
                    <label for="title">看板標題</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=(isset($banner['title'])) ? $banner['title'] : ''?>" />
                </div>

                <div class="form-group">
                    <label for="description">描述</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?=(isset($banner['description'])) ? $banner['description'] : ''?></textarea>
                </div>

                <div class="form-group">
                    <label for="link">超連結</label>
                    <input type="text" class="form-control" id="link" name="link" value="<?=(isset($banner['link'])) ? $banner['link'] : ''?>" />
                </div>

                <div class="form-group">
                    <label class="mr-4">狀態　　　</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status0" name="status" value="0" <?php if (! isset($banner['status']) || $banner['status'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status0">停用</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status1" name="status" value="1" <?php if (isset($banner['status']) && $banner['status'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status1">啟用</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">圖片　　　</label>
                    <input type="file" name="image" />

                    <?php if (isset($banner['filename']) && $banner['filename'] != '') : ?>
                    <div align="center"><img src="upload/banner/<?=$banner['filename']?>" /></div>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="col-md-12 col-sm-12 text-center mb-1">
            <button type="button" class="btn btn-primary active" onclick="saveSetting();">儲存</button>
        </div>
    </div>    

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
