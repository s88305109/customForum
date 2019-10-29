<script src="<?=BASEPATH?>/libraries/sceditor-2.1.3/minified/jquery.sceditor.bbcode.min.js"></script>
<script src="<?=BASEPATH?>/libraries/sceditor-2.1.3/languages/tw.js"></script>
<link rel="stylesheet" href="<?=BASEPATH?>/libraries/sceditor-2.1.3/minified/themes/default.min.css" />

<script type="text/javascript">
$(document).ready(function() {
    $('.page_input').on('keypress', function(event) {
        if (event.keyCode == 13) {
            goPage();
        }
    });

    $('.page_input').on('change', function(event) {
        goPage();
    });
});

function replyPost() {
    $.post('<?=BASEPATH?>/post/replyPost', { content : $('#editor').sceditor('instance').val(),  returnLastPage : $('#returnLastPage').prop('checked') }, function(result) {
        if (result != 'OK') {
            alert(result, '錯誤訊息');
        } else {
            alert('已保存回覆');
        }
    });
}

function goPost() {
    window.location.href = '<?=BASEPATH?>/board/post/c<?=$categoryID?>/b<?=$boardID?>';
}

function goPage() {
    window.location.href = '<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$boardID?>/' + $('.page_input').val();
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container d-none d-md-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?=BASEPATH?>/">論壇首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href= "<?=BASEPATH?>/board/c<?=$categoryID?>"><?=$categoryData['categoryTitle']?></a></li>
                <?php if (isset($boardID) && ! empty($boardID) && ! empty($boardData)) : ?>
                <li class="breadcrumb-item active" aria-current="page"><?=$boardData['title']?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<div class="container board">
    <?php if (isset($boardID) && ! empty($boardID) && ! empty($boardData)) : ?>
    <div class="row board_title_line d-none d-md-block">
        <div class="col-lg-6 board_title align-middle">
            <h1>
                <i class="<?=$boardData['iconName']?>"></i>
                <?=$boardData['title']?>
                <small title="<?=$boardData['description']?>"><?=$boardData['description']?></small>
            </h1>
        </div>

        <div class="col-lg-4 number_info">
            <!-- <span>1 ↑</span> 
            &nbsp;|&nbsp; 
            <span>428－</span> 
            &nbsp;|&nbsp; 
            <span>11 ↓</span> -->
        </div>

        <div class="col-lg-2 tool">
            <!-- 收藏本版 | 訂閱 -->
        </div>
    </div>
    <?php endif; ?>

    <div class="row board_nav d-none d-md-flex">
        <div class="col-lg-3">
            <button type="button" class="btn post_btn" onclick="goPost();">發 帖 &nbsp; <i class="fas fa-caret-down"></i></button>
        </div>

        <?php
        if (! empty($boardID))
            $navLink = BASEPATH.'/board/c'.$categoryID.'/b'.$boardID.'/';
        else
            $navLink = BASEPATH.'/board/c'.$categoryID.'/';

        $totalPages = ceil($topics['records'] / $topics['per']);

        if ($totalPages == 0)
            $totalPages = 1;
        ?>
        <div class="col-lg-9"></div>
    </div>

    <div class="row board_nav d-block d-md-none">
        <?php
        if (! empty($boardID))
            $navLink = BASEPATH.'/board/c'.$categoryID.'/b'.$boardID.'/';
        else
            $navLink = BASEPATH.'/board/c'.$categoryID.'/';

        $totalPages = ceil($topics['records'] / $topics['per']);

        if ($totalPages == 0)
            $totalPages = 1;
        ?>
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination">

                    <?php if ($topics['page'] > 1) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?>1"><i class="fas fa-step-backward"></i></a></li>
                    <?php endif; ?>

                    <li class="page-item">
                        <?php if ($topics['page'] > 1) : ?>
                        <a class="page-link" href="<?=$navLink?><?=$topics['page'] - 1?>"><i class="fas fa-caret-left"></i></a>
                        <?php else : ?>
                        <a class="page-link"><i class="fas fa-caret-left"></i></a>
                        <?php endif; ?>
                    </li>
                    <li class="page-item active"><a class="page-link"><?=$topics['page']?> / <?=$totalPages?></a> </li>
                    <?php if ($totalPages >= $topics['page'] + 1) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$topics['page'] + 1?>"><i class="fas fa-caret-right"></i></a></li>
                    <?php else : ?>
                    <li class="page-item"><a class="page-link"><i class="fas fa-caret-right"></i></a></li>
                    <?php endif; ?>

                    <?php if ($topics['page'] < $totalPages) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$totalPages?>"><i class="fas fa-step-forward"></i></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row partition">
        <ul class="nav nav-pills">
            <li class="<?= empty($boardID) ? 'active' : '' ?>">
                <a href="<?=BASEPATH?>/board/c<?=$categoryID?>">全部</a>
            </li>

            <?php foreach((array)$categoryBoards as $row) : ?>
            <li class="<?= ($boardID == $row['boardID']) ? 'active' : '' ?>">
                <a href="<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$row['boardID']?>"><?=$row['title']?>
                    <span class="badge"><?=$row['posts']?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="list">
        <div class="row caption d-none d-md-flex">
            <div class="col-lg-6 title">
                主題
            </div>

            <div class="col-lg-2">
                作者
            </div>

            <div class="col-lg-2">
                回復 / 查看
            </div>

            <div class="col-lg-2">
                最後發表
            </div>
        </div>

        <?php
        foreach((array)$topics['list'] as $row) : 
            $showDateClass = '';

            if (date('Y-m-d') == date('Y-m-d', strtotime($row['postTime']))) {
                if (time() - strtotime($row['postTime']) <= 3600) {
                    $showDate = floor((time() - strtotime($row['postTime'])) / 60).'分鐘前';
                } else if (time() - strtotime($row['postTime']) <= 43200) {
                    $showDate = floor((time() - strtotime($row['postTime'])) / 3600).'小時前';
                } else {
                    $showDate = '今天 '.date('H:i', strtotime($row['postTime']));
                }

                $showDateClass = 'recent';
            } else if (date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($row['postTime']))) {
                $showDate = '昨天 '.date('H:i', strtotime($row['postTime']));
            } else {
                $showDate = date('Y-n-j', strtotime($row['postTime']));
            }

            if (date('Y-m-d') == date('Y-m-d', strtotime($row['lastUpdateTime']))) {
                if (time() - strtotime($row['lastUpdateTime']) <= 3600) {
                    $showDate2 = floor((time() - strtotime($row['lastUpdateTime'])) / 60).'分鐘前';
                } else if (time() - strtotime($row['lastUpdateTime']) <= 43200) {
                    $showDate2 = floor((time() - strtotime($row['lastUpdateTime'])) / 3600).'小時前';
                } else {
                    $showDate2 = '今天 '.date('H:i', strtotime($row['lastUpdateTime']));
                }
            } else if (date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($row['lastUpdateTime']))) {
                $showDate2 = '昨天 '.date('H:i', strtotime($row['lastUpdateTime']));
            } else {
                $showDate2 = date('Y-n-j H:i', strtotime($row['lastUpdateTime']));
            }
        ?>
        <div class="row item">
            <div class="col-lg-6 col-sm-12 title">
                <?php if ($memberIdentity > 1) : ?>
                <input type="checkbox" class="form-check-input" name="topicIDs[]" value="<?=$row['topicID']?>" />
                <?php endif; ?>
                <a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>">
                    <?=$row['title']?>
                    <?php if ($row['firstPost'] == 1) : ?><span class="label">新人帖</span><?php endif; ?>
                    <?php if (time() - strtotime($row['postTime']) <= 604800 && ! Topic::browseHistory($row['topicID'])) : ?><span class="new">New !</span><?php endif; ?>
                </a>
            </div>

            <div class="col-lg-2 d-none d-md-block">
                <a href="<?=BASEPATH?>/member/<?=$row['memberID']?>" target="_blank"><?=$row['nickName']?></a><br />
                <span class="<?=$showDateClass?>"><?=$showDate?></span>
            </div>

            <div class="col-lg-2 d-none d-md-block">
                <?=$row['replies']?><br />
                <?=$row['views']?>
            </div>

            <div class="col-lg-2 d-none d-md-block">
                <a href="<?=BASEPATH?>/member/<?=$row['lastUpdateMemberID']?>" target="_blank"><?=$row['lastUpdateNickName']?></a> <br />
                <span class="old"><?=$showDate2?></span>
            </div>

            <div class="col-sm-12 d-md-none smInfo">
                <span class="thumb"><i class="far fa-thumbs-up"></i> <?=$row['views']?></span>
                <span class="comment"><i class="far fa-comment-dots"></i> <?=$row['replies']?></span>
                <span class="post"><a href="<?=BASEPATH?>/member/<?=$row['lastUpdateMemberID']?>"><?=$row['lastUpdateNickName']?></a> &nbsp; <?=$showDate2?></span>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="row board_nav d-block d-md-none">
        <?php
        if (! empty($boardID))
            $navLink = BASEPATH.'/board/c'.$categoryID.'/b'.$boardID.'/';
        else
            $navLink = BASEPATH.'/board/c'.$categoryID.'/';

        $totalPages = ceil($topics['records'] / $topics['per']);

        if ($totalPages == 0)
            $totalPages = 1;
        ?>
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination">

                    <?php if ($topics['page'] > 1) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?>1"><i class="fas fa-step-backward"></i></a></li>
                    <?php endif; ?>

                    <li class="page-item">
                        <?php if ($topics['page'] > 1) : ?>
                        <a class="page-link" href="<?=$navLink?><?=$topics['page'] - 1?>"><i class="fas fa-caret-left"></i></a>
                        <?php else : ?>
                        <a class="page-link"><i class="fas fa-caret-left"></i></a>
                        <?php endif; ?>
                    </li>
                    <li class="page-item active"><a class="page-link"><?=$topics['page']?> / <?=$totalPages?></a> </li>
                    <?php if ($totalPages >= $topics['page'] + 1) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$topics['page'] + 1?>"><i class="fas fa-caret-right"></i></a></li>
                    <?php else : ?>
                    <li class="page-item"><a class="page-link"><i class="fas fa-caret-right"></i></a></li>
                    <?php endif; ?>

                    <?php if ($topics['page'] < $totalPages) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$totalPages?>"><i class="fas fa-step-forward"></i></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <div class="clearfix"></div>

    <?php if ($memberIdentity > 1) : ?>
    <script type="text/javascript">
    function loadBoards() {
        $('#selectBoard').load('<?=BASEPATH?>/board/loadBoards', { selectCategory: $('#selectCategory').val() });        
    }

    function manageBatchMoveTopics() {
        $.post('<?=BASEPATH?>/manage/manageBatchMoveTopics', $('input[name="topicIDs[]"]').serialize() + '&boardID=<?=$boardID?>&selectBoard=' + $('#selectBoard').val(), function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.reload();
            }
        });
    }

    function manageBatchDelTopics() {
        $.post('<?=BASEPATH?>/manage/manageBatchDelTopics', $('input[name="topicIDs[]"]').serialize() + '&boardID=<?=$boardID?>&cause=' + $('#cause').val(), function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.reload();
            }
        });
    }
    </script>
    <div class="row management">
        <div class="col-12">
            <fieldset>
                <legend>版務管理</legend>
                將已選取的主題批量移動到：

                <select class="form-control" id="selectCategory" name="selectCategory" onchange="loadBoards();">
                    <?php foreach ((array)$activeCategory as $row) : ?>
                    <option value="<?=$row['categoryID']?>" title="<?=$row['description']?>" <?=($setManageDefaultCategoryID == $row['categoryID']) ? 'selected' : '' ?>><?=$row['title']?></option>
                    <?php endforeach; ?>
                </select>

                <select class="form-control" id="selectBoard" name="selectBoard">
                    <?php foreach ((array)$activeBoard as $row) : ?>
                    <option value="<?=$row['boardID']?>" title="<?=$row['description']?>" <?=($setManageDefaultBoardID == $row['boardID']) ? 'selected' : '' ?>><?=$row['title']?></option>
                    <?php endforeach; ?>
                </select>
                &nbsp;
                &nbsp;
                <button type="button" class="btn btn-danger font-weight-bold" onclick="manageBatchMoveTopics();">搬移</button>

                <hr/ > 

                將已選取的主題批量刪除：
                <select class="form-control" id="cause" name="cause">
                    <option value="0">一般刪除</option>
                    <option value="1">違規主題刪除</option>
                </select>
                &nbsp;
                &nbsp;
                <button type="button" class="btn btn-danger font-weight-bold" onclick="manageBatchDelTopics();">刪除</button>
            </fieldset>
        </div>
    </div>
    <?php endif; ?>

    <div class="row divline">&nbsp;</div>

    <div class="post">
        <div class="row board_nav">
            <div class="col-lg-3">
                <button type="button" class="btn post_btn" onclick="goPost();">發 帖 &nbsp; <i class="fas fa-caret-down"></i></button>
            </div>

            <div class="col-lg-9">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item">
                            <?php if ($topics['page'] > 1) : ?>
                            <a class="page-link" href="<?=$navLink?><?=$topics['page'] - 1?>"><i class="fas fa-caret-left"></i> &nbsp; 上一頁</a>
                            <?php else : ?>
                            <a class="page-link"><i class="fas fa-caret-left"></i> &nbsp; 上一頁</a>
                            <?php endif; ?>
                        </li>
                        <?php 
                        if ($topics['page'] <= 4) {
                            $u = ($totalPages < 4) ? $totalPages : 4;

                            for($i = 1; $i <= $u; $i++) {
                                if ($topics['page'] == $i)
                                    $activeClass = 'active';
                                else
                                    $activeClass = '';
                                    
                                echo "<li class=\"page-item {$activeClass}\"><a class=\"page-link\" href=\"{$navLink}{$i}\">{$i}</a></li>";
                            }

                            if ($totalPages > $u + 1) {
                                $u++;

                                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$navLink}{$u}\">{$u}</a></li>";
                            }

                            if ($totalPages > $u + 1) {
                                $u++;

                                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$navLink}{$u}\">{$u}</a></li>";
                            }

                            $maxDisplayPage = $u;
                        } else {
                            if ($topics['page'] > 4)
                                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$navLink}1\">1 ...</a></li>";

                            for($i = $topics['page'] - 2; $i < $topics['page']; $i++) {
                                if ($topics['page'] == $i)
                                    $activeClass = 'active';
                                else
                                    $activeClass = '';
                                    
                                echo "<li class=\"page-item {$activeClass}\"><a class=\"page-link\" href=\"{$navLink}{$i}\">{$i}</a></li>";
                            }

                            $u = ($totalPages < $topics['page'] + 2) ? $totalPages : $topics['page'] + 2;

                            for($i = $topics['page']; $i <= $u; $i++) {
                                if ($topics['page'] == $i)
                                    $activeClass = 'active';
                                else
                                    $activeClass = '';
                                    
                                echo "<li class=\"page-item {$activeClass}\"><a class=\"page-link\" href=\"{$navLink}{$i}\">{$i}</a></li>";
                            }

                            $maxDisplayPage = $u;
                        }

                        if ($totalPages > $maxDisplayPage)
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$navLink}{$totalPages}\">... {$totalPages}</a></li>";
                        ?>
                        <li class="page-item"><a class="page-jump"><input type="text" class="page_input" name="page" value="<?=$topics['page']?>" /> / <?=$totalPages?> 頁</a></li>
                        <?php if ($totalPages >= $topics['page'] + 1) : ?>
                        <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$topics['page'] + 1?>">下一頁 &nbsp; <i class="fas fa-caret-right"></i></a></li>
                        <?php else : ?>
                        <li class="page-item"><a class="page-link">下一頁 &nbsp; <i class="fas fa-caret-right"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
