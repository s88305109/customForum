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
        url: '<?=BASEPATH?>/admin/searchSave' ,  
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
                window.location.href = '<?=BASEPATH?>/admin/searchManage';
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
    			<li class="breadcrumb-item active" aria-current="page">熱搜管理</li>
                <li class="breadcrumb-item active" aria-current="page">熱搜項目設定</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container">
    <div class="row news">
		<h3>熱搜項目設定</h3>

        <div class="col-md-12 col-sm-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
                <div class="form-group">
                    <label for="searchstr">熱搜內容</label>
                    <input type="text" class="form-control" id="searchstr" name="searchstr" value="<?=(isset($search['searchstr'])) ? $search['searchstr'] : ''?>" />
                </div>

                <div class="form-group">
                    <label for="count">搜尋次數</label>
                    <input type="text" class="form-control" id="count" name="count" value="<?=(isset($search['count'])) ? $search['count'] : ''?>" />
                </div>
            </form>
        </div>

        <div class="col-md-12 col-sm-12 text-center mb-1">
            <button type="button" class="btn btn-primary active" onclick="saveSetting();">儲存</button>
        </div>
    </div>    

	<?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
