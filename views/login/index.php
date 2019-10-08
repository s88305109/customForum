<style>
.loginBlock{
    margin: 0 auto;
    text-align: left;
    width: 300px;
}
.loginBlock h2 {
    font-size: 125%;
    font-weight: bold;
    text-align: center;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#login input').on('keypress', function(event) {
        if (event.keyCode == 13) {
            memberLogin();
        }
    });
});

var loading = 0;
function memberLogin() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.loginButton').prop('disabled', true);
    $('.ajaxLoader').fadeIn();

    $.post('<?=BASEPATH?>/login/memberLogin', $('#login').serialize(), function(result) {
        if (result.result != 'success') {
            loading = 0;
            document.getElementById('captcha').src = '<?=BASEPATH?>/libraries/securimage/securimage_show.php?' + Math.random();
            $('input[name="code"]').val('');
            $('.loginButton').prop('disabled', false);
            $('.ajaxLoader').fadeOut();
            alert(result.msg, '錯誤訊息');
        } else {
            window.location.href = '<?=BASEPATH?>/';
        }
    }, 'json');
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page">論壇首頁</li>
                <li class="breadcrumb-item active" aria-current="page">會員登入</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    
    <div class="row">
        <div class="loginBlock">
            <h2>會員登入</h2>
            <form id="login">
                <div class="form-group">
                    <label for="email">電子郵件地址</label>
                    <input type="email" class="form-control" name="email" placeholder="請輸入您的電子郵件地址" />
                </div>

                <div class="form-group">
                    <label for="password">會員密碼</label>
                    <input type="password" class="form-control" name="password" placeholder="請輸入您的會員密碼" />
                </div>

                <div class="form-group" align="center">
                    <img id="captcha" src="<?=BASEPATH?>/libraries/securimage/securimage_show.php" alt="CAPTCHA Image" />
                    <br />
                    <a href="#" onclick="document.getElementById('captcha').src = '<?=BASEPATH?>/libraries/securimage/securimage_show.php?' + Math.random(); return false">[ 重新顯示驗證碼 ]</a>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="code" size="10" maxlength="6" placeholder="請輸入上方圖片中顯示的驗證碼" />
                </div>
                
                <div align="center">
                    <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" /><br />
                    <button type="button" class="btn btn-primary loginButton" onclick="memberLogin();">登入</button>
                </div>
            </form>
        </div>
    </div>

    <hr />

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
