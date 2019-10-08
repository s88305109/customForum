<script type="text/javascript">
$(document).ready(function() {
    $('ul.nav a').on('click', function(event) {
        event.preventDefault();

        $('ul.nav a').removeClass('active');
        $(this).addClass('active');

        $('.info').hide();
        $('.topics').hide();
        $('.coupon').hide();
        $('.admin').hide();
        $('.' + $(this).data('target')).show();
    });
});

var loading = 0;

function sendVailMail() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.ajaxLoader').fadeIn();

    $.post('<?=BASEPATH?>/member/sendVailMail', function(result) {
        if (result != 'OK') {
            loading = 0;
            $('.ajaxLoader').fadeOut();
            alert(result, '錯誤訊息');
        } else {
            alert('驗證信件已發送至您的信箱');
            $('.ajaxLoader').fadeOut();
        }
    });
}

function exchange() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.ajaxLoader').fadeIn();

    $.post('<?=BASEPATH?>/member/exchange', { pay : $('#pay').val() }, function(result) {
        if (result.result != 'success') {
            loading = 0;
            $('.ajaxLoader').fadeOut();
            alert(result.msg, '錯誤訊息');
        } else {
            if (confirm(result.msg)) {
                $.post('<?=BASEPATH?>/member/exchange2', { pay : result.pay }, function(result2) {
                    if (result2.result != 'success') {
                        loading = 0;
                        $('.ajaxLoader').fadeOut();
                        alert(result2.msg, '錯誤訊息');
                    } else {
                        alert('已成功兌換欣台幣');
                        window.location.reload();
                    }
                }, 'json');
            } else {
                loading = 0;
                $('.ajaxLoader').fadeOut();
            }
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
                <li class="breadcrumb-item" aria-current="page"><?=$memberInfo['nickName']?></li>
                <li class="breadcrumb-item active" aria-current="page">個人資料</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container member">
    <div class="row headBar">
        <div class="imgbox">
            <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['memberID'] == $memberInfo['memberID']) : ?>
            <a href="<?=BASEPATH?>/member/avatar">
            <?php endif; ?>

            <?php if ($memberInfo['avatar'] != '') : ?>
            <img src="<?=BASEPATH?>/upload/avatar/<?=$memberInfo['avatar']?>">
            <?php else : ?>
            <img src="<?=BASEPATH?>/images/avatar.jpg">
            <?php endif; ?>

            <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['memberID'] == $memberInfo['memberID']) : ?>
            </a>
            <?php endif; ?>
        </div>
        
        <div>
            <h2><?=$memberInfo['nickName']?></h2>
            <h4><a href="<?=(empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https'?>://<?=$_SERVER['SERVER_NAME']?><?=BASEPATH?>/member/<?=$memberInfo['memberID']?>"><?=(empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https'?>://<?=$_SERVER['SERVER_NAME']?><?=BASEPATH?>/member/<?=$memberInfo['memberID']?></a></h4>
        </div>
    </div>

    <div class="row">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#info" data-target="info">個人資料</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#topics"  data-target="topics">近期主題</a>
            </li>
            <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['memberID'] == $memberInfo['memberID']) : ?>
            <li class="nav-item">
                <a class="nav-link" href="#coupon"  data-target="coupon">欣台幣兌換</a>
            </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['admin'] == 1) : ?>
            <li class="nav-item">
                <a class="nav-link" href="#admin"  data-target="admin">管理員功能</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="row info">
        <div class="col-12"><h4><?=$memberInfo['nickName']?> (UID: <?=$memberInfo['memberID']?>)</h4></div>

        <div class="col-lg-4 col-sm-12">        
            郵箱狀態 
            <?php if ($memberInfo['level'] == 1) : ?>
            <b>未驗證</b> 
                <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['memberID'] == $memberInfo['memberID']) : ?>
                <a onclick="sendVailMail();">(點擊發送驗證信件)</a> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                <?php endif; ?>
            <?php else : ?>
            <b>已驗證</b>
            <?php endif; ?>
        </div>

        <div class="col-lg-8 col-sm-12">
            統計信息 
            <b>回帖數 <?=$memberInfo['replies']?></b> &nbsp;&nbsp;&nbsp; |
            <b>主題數 <?=$memberInfo['posts']?></b>
        </div>

        <div class="col-12">
            暱稱 <b><?=$memberInfo['nickName']?></b>
        </div>

        <div class="col-12"><h4>活耀概況</h4></div>

        <div class="col-12">
            用戶組 <b><?=$memberInfo['title']?></b>
        </div>

        <div class="col-lg-4 col-sm-12">
            註冊時間 <b><?=$memberInfo['registerTime']?></b>
        </div>

        <div class="col-lg-4 col-sm-12">
            最後訪問 <b><?=$memberInfo['lastLoginTime']?></b>
        </div>

        <div class="col-lg-4 col-sm-12">
            上次活動時間 <b><?=$memberInfo['lastActivityTime']?></b>
        </div>

        <div class="col-lg-4 col-sm-12">
            上次發表時間 <b><?=$memberInfo['lastPostTime']?></b>
        </div>

        <div class="col-12"><h4>統計信息</h4></div>

        <div class="col-lg-4 col-sm-12">
            積分 <b><?=$memberInfo['points']?></b>
        </div>

        <div class="col-lg-4 col-sm-12">
            金錢 <b><?=$memberInfo['coin']?></b>
        </div>
    </div>

    <div class="row topics">
        <?php foreach ((array)$memberRecentPosts as $row) : ?>
        <div class="col-12 item">
            <a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>" target="_blank"><h4><?=$row['title']?></h4></a>

            <p>
                <a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>" target="_blank">
                    <?php
                    $parser = new \SBBCodeParser\Node_Container_Document();
                    $content = strip_tags($parser->parse($row['content'])->get_html());

                    if (mb_strlen($content, 'UTF-8') > 200) {
                        $content = mb_substr($content, 0, 200, 'UTF-8').' ...';
                    }

                    echo $content;
                    ?>
                </a>
            </p>

            <p><?=date('Y-m-d H:i', strtotime($row['postTime']))?> 發表於 <?=$row['boardTitle']?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['memberID'] == $memberInfo['memberID']) : ?>
    <div class="row coupon">
        <div class="list">
            <div class="block">
                <div>
                    <i class="fas fa-money-bill-alt"></i> 欣台幣
                </div>
                <div class="text-right">
                    <span class="money">剩餘 <?=Member::countSinyaCoupon($memberInfo['originalCustID'])?> 元</span>
                </div>
            </div>

            <div class="block">
                <div>
                    <i class="fas fa-coins"></i> 金錢
                </div>
                <div class="text-right">
                    <span class="money">剩餘 <?=$memberInfo['coin']?> 元</span>
                </div>
            </div>

            <div class="block">
                <div>
                    <i class="fas fa-asterisk"></i> 30 點金錢兌換 1 點欣台幣
                </div>

                <div class="text-right">
                    兌換 <input type="text" class="form-control" id="pay" value="<?=floor($memberInfo['coin'] / 30) * 30?>" /> 點金錢
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success" onclick="exchange();">兌換</button> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['nsf_member']['memberID']) && $_SESSION['nsf_member']['admin'] == 1) : ?>
    <div class="row admin">
        <div class="list">
            <?php if ($memberInfo['status'] == 1) : ?>
            <div class="mb-2 text-success"><h3>會員論壇權限已啟用</h3></div>
            <div class="block">
                <div>
                    <i class="fas fa-ban"></i> 停用會員論壇功能
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-danger" onclick="banMember();">停用</button> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                </div>
            </div>

            <script type="text/javascript">
            function banMember() {
                if (loading == 1)
                    return false;

                if (! confirm('是否確定要停用該會員的論壇權限？'))
                    return false;

                loading = 1;
                $('.ajaxLoader').fadeIn();

                $.post('<?=BASEPATH?>/admin/banMember', { id : '<?=$memberInfo['memberID']?>' }, function(result) {
                    if (result != 'OK') {
                        loading = 0;
                        $('.ajaxLoader').fadeOut();
                        alert(result, '錯誤訊息');
                    } else {
                        window.location.reload();
                    }
                });
            }
            </script>
            <?php else : ?>
            <div class="mb-2 text-danger"><h3>會員論壇權限已停用</h3></div>
            <div class="block">
                <div>
                    <i class="fas fa-lock-open"></i> 啟用會員論壇功能
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-success" onclick="unbanMember();">啟用</button> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                </div>
            </div>

            <script type="text/javascript">
            function unbanMember() {
                if (loading == 1)
                    return false;

                if (! confirm('是否確定要啟用該會員的論壇權限？'))
                    return false;

                loading = 1;
                $('.ajaxLoader').fadeIn();

                $.post('<?=BASEPATH?>/admin/unbanMember', { id : '<?=$memberInfo['memberID']?>' }, function(result) {
                    if (result != 'OK') {
                        loading = 0;
                        $('.ajaxLoader').fadeOut();
                        alert(result, '錯誤訊息');
                    } else {
                        window.location.reload();
                    }
                });
            }
            </script>
            <?php endif; ?>
        </div>

        <div class="list">
            <div class="mb-2 text-success"><h3>會員積分</h3></div>
            <div class="block">
                <div>
                    <i class="fas fa-user-cog"></i> 修改會員積分
                </div>
                <div class="text-right">
                    <input type="text" class="form-control" id="points" value="<?=$memberInfo['points']?>" /> &nbsp;&nbsp;&nbsp;&nbsp; 
                    <button type="button" class="btn btn-danger" onclick="pointsAdjust();">修改</button> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                </div>
                
                <hr />

                <div>
                    <i class="fas fa-coins"></i> 修改會員金幣
                </div>
                <div class="text-right">
                    <input type="text" class="form-control" id="coin" value="<?=$memberInfo['coin']?>" /> &nbsp;&nbsp;&nbsp;&nbsp; 
                    <button type="button" class="btn btn-danger" onclick="coinAdjust();">修改</button> <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
                </div>
            </div>

            <script type="text/javascript">
            function pointsAdjust() {
                if (loading == 1)
                    return false;

                if (! confirm('是否確定要修改該會員的積分？'))
                    return false;

                loading = 1;
                $('.ajaxLoader').fadeIn();

                $.post('<?=BASEPATH?>/admin/pointsAdjust', { id : '<?=$memberInfo['memberID']?>', points : $('#points').val() }, function(result) {
                    if (result != 'OK') {
                        loading = 0;
                        $('.ajaxLoader').fadeOut();
                        alert(result, '錯誤訊息');
                    } else {
                        window.location.reload();
                    }
                });
            }

            function coinAdjust() {
                if (loading == 1)
                    return false;

                if (! confirm('是否確定要修改該會員的金幣？'))
                    return false;

                loading = 1;
                $('.ajaxLoader').fadeIn();

                $.post('<?=BASEPATH?>/admin/coinAdjust', { id : '<?=$memberInfo['memberID']?>', coin : $('#coin').val() }, function(result) {
                    if (result != 'OK') {
                        loading = 0;
                        $('.ajaxLoader').fadeOut();
                        alert(result, '錯誤訊息');
                    } else {
                        window.location.reload();
                    }
                });
            }
            </script>
        </div>
    </div>
    <?php endif; ?>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
