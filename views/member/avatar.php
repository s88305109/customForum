<script type="text/javascript">
var loading = 0;

function uploadPic() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.upload').prop('disabled', true);
    $('.ajaxLoader').fadeIn();

    var formData = new FormData($('#frm')[0]);  

    $.ajax({  
        url: '<?=BASEPATH?>/member/uploadPic' ,  
        type: 'POST',  
        data: formData,  
        async: false,  
        cache: false,  
        contentType: false,  
        processData: false,  
        success: function (result) {  
            if (result != 'OK') {
                alert(result);
                loading = 0;
                $('.upload').prop('disabled', false);
                $('.ajaxLoader').fadeOut();
            } else {
                window.location.href = '<?=BASEPATH?>/member/<?=$memberInfo['memberID']?>';
            }
        },  
        error: function (result) {  
            alert(result);
            loading = 0;
            $('.upload').prop('disabled', false);
            $('.ajaxLoader').fadeOut();
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
                <li class="breadcrumb-item" aria-current="page">論壇首頁</li>
                <li class="breadcrumb-item" aria-current="page"><?=$memberInfo['nickName']?></li>
                <li class="breadcrumb-item active" aria-current="page">修改頭像</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container member">
    <div class="row headBar">
        <div class="imgbox">
            <img src="<?=BASEPATH?>/images/avatar.jpg">
        </div>
        
        <form class="picUpload" id="frm">
            <div class="form-group">
                <label for="pic">請選擇要上傳的頭像圖片</label>
                <br />
                <input type="file" id="pic" name="pic" accept=".jpg,.gif,.png" />
                <button type="button" class="btn btn-primary upload" onclick="uploadPic();">上傳</button>
                <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
            </div>
        </form>
    </div>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
