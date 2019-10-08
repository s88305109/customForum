<script type="text/javascript">
$(document).ready(function() {
    $('#searchstr').on('keypress', function(event) {
        if (event.keyCode == 13) {
            articleSearch();
        }
    });
});

function articleSearch() {
    if ($('#searchstr').val() == '') {
        alert('請輸入搜尋內容');
        return false;
    }

    window.location.href = '<?=BASEPATH?>/search/' + encodeURIComponent($('#searchstr').val());
}
</script>

<div class="top_nav">
    <div class="container">
        <div class="float-left">
            <?php 
            $activeAnnouncement = ForumLayout::getActiveAnnouncement();

            if (! empty($activeAnnouncement) && count($activeAnnouncement) > 0)
                echo '<span class="title">公告</span>';

            $i = 0;

            foreach((array)$activeAnnouncement as $row) {
                if ($i > 0)
                    echo ' &nbsp; | &nbsp; ';
                if ($row['link'] != '')
                    echo "<a href=\"{$row['link']}\">";

                echo $row['title'];

                if ($row['link'] != '')
                    echo "</a>";

                $i++;
            }
            ?>
        </div>
        <div class="float-right">
            <span class="title">熱搜：</span>
            <?php
            $hotSearch = ForumLayout::getHotSearch();

            if (empty($hotSearch)) {
                echo "<a href=\"".BASEPATH."/search/開箱\">開箱</a>";
            } else {
                $i = 0;
                shuffle($hotSearch);
                foreach((array)$hotSearch as $row) {
                    if ($i >= 4)
                        break;
                    
                    echo "<a href=\"".BASEPATH."/search/{$row['searchstr']}\">{$row['searchstr']}</a> ";

                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>
<header>
    <div class="container">
        <div class="row">
            <div class="col-6 logo">
                <a href="<?=BASEPATH?>/" class="logo_pic"><img src="<?=BASEPATH?>/images/logo.png" alt="排排購"></a>
                <a href="https://www.facebook.com/sinyafan/" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://line.me/R/ti/p/%40wyf2547l" class="line" target="_blank"><i class="fab fa-line"></i></a>
            </div>
            <div class="col-6">
                <div class="search_block">
                    <input type="text" id="searchstr" placeholder="搜尋" value="<?=(isset($searchstr)) ? urldecode($searchstr) : ''?>" />
                    <button type="button" class="btn" onclick="articleSearch();"><i class="fas fa-search"></i></button>
                </div>

                <div class="float-right login">
                    <?php if (! isset($_SESSION['nsf_member']) || ! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) : ?>
                        <span><i class="far fa-user"></i> <a href="https://www.sinya.com.tw/">註冊</a> / <a href="<?=BASEPATH?>/login">登入</a></span>
                    <?php else : ?>
                        <a href="<?=BASEPATH?>/member/<?=$_SESSION['nsf_member']['memberID']?>"><?=$_SESSION['nsf_member']['nickName']?> 你好</a> &nbsp;&nbsp;
                        <span>(<a href="<?=BASEPATH?>/logout">登出會員</a>)</span>

                        <?php if ($_SESSION['nsf_member']['admin'] == 1) : ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?=BASEPATH?>/admin/forumManage';">後台管理</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="menu">
    <div class="container">
        <ul>
            <li><a href="<?=BASEPATH?>/" class="selected">論壇首頁</a></li>
            <li><a href="<?=BASEPATH?>/board/c2/b4">筆電詢價</a></li>
            <li><a href="<?=BASEPATH?>/board/c2/b5">電腦組裝估價</a></li>
            <li><a href="<?=BASEPATH?>/board/c1/b1">優惠情報</a></li>
            <li><a href="https://www.sinya.com.tw">欣亞官網</a></li>
        </ul>
    </div>
</nav>
