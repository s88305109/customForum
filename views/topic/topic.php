<script src="<?=BASEPATH?>/libraries/sceditor-2.1.3/development/jquery.sceditor.bbcode.js"></script>
<script src="<?=BASEPATH?>/libraries/sceditor-2.1.3/languages/tw.js"></script>
<link rel="stylesheet" href="<?=BASEPATH?>/libraries/sceditor-2.1.3/minified/themes/default.min.css" />
<script src="<?=BASEPATH?>/libraries/jqueryupload/jqueryupload.js"></script>

<script type="text/javascript">
var loading = 0;
var changed = 0;

$(document).ready(function() {
    var textarea = document.getElementById('editor');
    sceditor.create(textarea, {
        width: '100%',
        height: '400px',
        emoticonsRoot : '<?=BASEPATH?>/images/',
        toolbarExclude: 'code,email,date,time,ltr,rtl,print,maximize',
        format: 'bbcode',
        locale: 'tw',
        style: '<?=BASEPATH?>/libraries/sceditor-2.1.3/minified/themes/content/default.min.css'
    });

    sceditor.instance(textarea).bind('nodechanged', function(e) {
        changed = 1;
    });

    setInterval('draftHandle();', 10000);

    $('.page_input').on('keypress', function(event) {
        if (event.keyCode == 13) {
            goPage();
        }
    });

    $('.page_input').on('change', function(event) {
        goPage();
    });
});

function doUpload(obj) {
    $(obj).upload('<?=BASEPATH?>/post/uploader', function(res) {
        $(this).val('');
        
        if (res.result != 'success') {
            alert(res.msg);
        } else {
            $('#image').val(res.image);
        }
    }, 'json');
}

function replyPost() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.topicPost').prop('disabled', true);
    $('.ajaxLoader').fadeIn();

    $.post('<?=BASEPATH?>/post/replyPost', { content : $('#editor').sceditor('instance').val(), topicID : '<?=$topicData['topicID']?>', returnLastPage : $('#returnLastPage').prop('checked') }, function(result) {
        if (result.msg != 'OK') {
            loading = 0;
            $('.topicPost').prop('disabled', false);
            $('.ajaxLoader').fadeOut();
            alert(result.msg, '錯誤訊息');
        } else {
            $('.topicPost').html('回覆已成功儲存');
            $('.ajaxLoader').fadeOut();
            window.location.href = '<?=BASEPATH?>/topic/<?=$topicData['topicID']?>/' + result.returnPage;
        }
    }, 'json');
}

function topicReview(review) {
    $.post('<?=BASEPATH?>/topic/topicReview', { topicID : '<?=$topicData['topicID']?>', review : review }, function(result) {
        if (result != 'OK') {
            alert(result, '錯誤訊息');
        } else {
            if (review == 1) {
                $('.awesome').addClass('text-success').addClass('font-weight-bold');
                $('.trample').removeClass('text-danger').removeClass('font-weight-bold');
            } else {
                $('.awesome').removeClass('text-success').removeClass('font-weight-bold');
                $('.trample').addClass('text-danger').addClass('font-weight-bold');
            }
        }
    });
}

function topicCollection() {
    $.post('<?=BASEPATH?>/topic/topicCollection', { topicID : '<?=$topicData['topicID']?>' }, function(result) {
        if (result != 'OK') {
            alert(result, '錯誤訊息');
        } else {
            if ($('.collection').hasClass('text-warning')) {
                $('.collection').removeClass('text-warning').removeClass('font-weight-bold');
            } else {
                $('.collection').addClass('text-warning').addClass('font-weight-bold');
            }
        }
    });
}

function goReply() {
    $([document.documentElement, document.body]).animate({
        scrollTop: $('.editor_line').offset().top
    }, 200);
}

function goPost() {
    window.location.href = '<?=BASEPATH?>/board/post/c<?=$categoryID?>/b<?=$boardID?>';
}

function goPage() {
    window.location.href = '<?=BASEPATH?>/topic/<?=$topicID?>/' + $('.page_input').val();
}

function topicEdit() {
    window.location.href = '<?=BASEPATH?>/board/topicEdit/<?=$topicID?>';
}

function draftHandle() {
    if (changed == 1) {
        saveDraft();
    }
}

function saveDraft() {
    if (loading == 1)
        return false;
    
    $.post('<?=BASEPATH?>/post/saveDraft', { content : $('#editor').sceditor('instance').val(), subjectID : '<?=$topicData['topicID']?>' }, function(result) {
        changed = 0;
    });
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container d-none d-md-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?=BASEPATH?>/">論壇首頁</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?=BASEPATH?>/board/c<?=$categoryID?>"><?=$categoryData['categoryTitle']?></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$boardID?>"><?=$boardData['title']?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$topicData['title']?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container board topic">
    <div class="row board_nav d-none d-md-flex">
        <div class="col-md-3">
            <button type="button" class="btn post_btn" onclick="goPost();">發 帖 &nbsp; <i class="fas fa-caret-down"></i></button>
        </div>

        <?php
        $navLink = BASEPATH.'/topic/'.$topicID.'/';

        $totalPages = ceil($replies['records'] / $replies['per']);

        if ($totalPages == 0)
            $totalPages = 1;
        ?>
        <div class="col-md-9">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <?php if ($replies['page'] > 1) : ?>
                        <a class="page-link" href="<?=$navLink?><?=$replies['page'] - 1?>"><i class="fas fa-caret-left"></i> &nbsp; 上一頁</a>
                        <?php else : ?>
                        <a class="page-link"><i class="fas fa-caret-left"></i> &nbsp; 上一頁</a>
                        <?php endif; ?>
                    </li>
                    <?php 
                    if ($replies['page'] <= 4) {
                        $u = ($totalPages < 4) ? $totalPages : 4;

                        for($i = 1; $i <= $u; $i++) {
                            if ($replies['page'] == $i)
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
                        if ($replies['page'] > 4)
                            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"{$navLink}1\">1 ...</a></li>";

                        for($i = $replies['page'] - 2; $i < $replies['page']; $i++) {
                            if ($replies['page'] == $i)
                                $activeClass = 'active';
                            else
                                $activeClass = '';
                                
                            echo "<li class=\"page-item {$activeClass}\"><a class=\"page-link\" href=\"{$navLink}{$i}\">{$i}</a></li>";
                        }

                        $u = ($totalPages < $replies['page'] + 2) ? $totalPages : $replies['page'] + 2;

                        for($i = $replies['page']; $i <= $u; $i++) {
                            if ($replies['page'] == $i)
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
                    <li class="page-item"><a class="page-jump"><input type="text" class="page_input" name="page" value="<?=$replies['page']?>" /> / <?=$totalPages?> 頁</a></li>
                    <?php if ($totalPages >= $replies['page'] + 1) : ?>
                    <li class="page-item"><a class="page-link" href="<?=$navLink?><?=$replies['page'] + 1?>">下一頁 &nbsp; <i class="fas fa-caret-right"></i></a></li>
                    <?php else : ?>
                    <li class="page-item"><a class="page-link">下一頁 &nbsp; <i class="fas fa-caret-right"></i></a></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$boardID?>"><i class="fas fa-caret-left"></i> &nbsp; 返回列表</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <?php if ($memberIdentity > 1) : ?>
    <script type="text/javascript">
    function loadBoards() {
        $('#selectBoard').load('<?=BASEPATH?>/board/loadBoards', { selectCategory: $('#selectCategory').val() });        
    }

    function manageBatchMoveTopics() {
        $.post('<?=BASEPATH?>/manage/manageBatchMoveTopics', 'topicIDs[]=<?=$topicData['topicID']?>&boardID=<?=$boardID?>&selectBoard=' + $('#selectBoard').val(), function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.reload();
            }
        });
    }

    function manageSetTopicTop() {
        $.post('<?=BASEPATH?>/manage/manageSetTopicTop', 'topicID=<?=$topicData['topicID']?>&top=' + $('#top').val(), function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.reload();
            }
        });
    }

    function manageBatchDelTopics() {
        $.post('<?=BASEPATH?>/manage/manageBatchDelTopics', 'topicIDs[]=<?=$topicData['topicID']?>&boardID=<?=$boardID?>&cause=' + $('#cause').val(), function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.href = '<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$boardID?>';
            }
        });
    }

    function manageBatchDelReplies() {
        $.post('<?=BASEPATH?>/manage/manageBatchDelReplies', $('input[name="replies[]"]').serialize() + '&topicID=<?=$topicData['topicID']?>', function(result) {
            if (result != 'OK') {
                alert(result, '錯誤訊息');
            } else {
                window.location.reload();
            }
        });
    }

    function addAwards() {
        var award = '<div class="award">' + $('.award').eq(0).html() + ' <button type="button" class="btn btn-secondary btn-sm" onclick="$(this).parent().remove();"> - </div>';

        $('.awards').append(award);
    }

    function lottery() {
        $.post('<?=BASEPATH?>/manage/lottery', $('.lottery').serialize(), function(result) {
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
                將本主題移動到：

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

                將本主題設定為置頂：

                <select class="form-control" id="top" name="top">
                    <option value="0">否</option>
                    <option value="1" <?php if ($topicData['top'] == 1) echo 'selected="selected"'; ?>>置頂</option>
                </select>
                &nbsp;
                &nbsp;
                <button type="button" class="btn btn-danger font-weight-bold" onclick="manageSetTopicTop();">設定</button>

                <hr/ > 

                將本主題刪除：
                <select class="form-control" id="cause" name="cause">
                    <option value="0">一般刪除</option>
                    <option value="1">違規主題刪除</option>
                </select>
                &nbsp;
                &nbsp;
                <button type="button" class="btn btn-danger font-weight-bold" onclick="manageBatchDelTopics();">刪除主題</button>

                <hr/ > 

                將已選取的回覆刪除：
                &nbsp;
                &nbsp;
                <button type="button" class="btn btn-danger font-weight-bold" onclick="manageBatchDelReplies();">刪除回覆</button>
            </fieldset>
        </div>
    </div>

    <div class="row management">
        <div class="col-12">
            <fieldset>
                <legend>留言抽獎</legend>
                
                <?php if (empty($lottery)) : ?>
                <form class="lottery">
                    <input type="hidden" name="topicID" value="<?=$topicData['topicID']?>" />

                    <div class="awards">
                        <div class="award">抽出 <input type="text" class="form-control text-center" name="number[]" value="1" size="3" /> 人贈送 
                            <input type="text" class="form-control text-center" name="points[]" value="10" size="5" /> 點積分 &nbsp;&nbsp;|&nbsp;&nbsp;
                            <input type="text" class="form-control text-center" name="coin[]" value="10" size="5" /> 點金幣 &nbsp;&nbsp;|&nbsp;&nbsp;
                            獎品 <input type="text" class="form-control text-center" name="item[]" value="" size="20" />
                        </div>
                    </div>

                    <hr />

                    <div>
                        <button type="button" class="btn btn-success font-weight-bold" onclick="addAwards();">增加獎項 +</button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-primary font-weight-bold" onclick="lottery();">進行抽獎</button>
                    </div>
                </form>
                <?php else : ?>
                <h2>中獎名單</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">暱稱</th>
                            <th scope="col">獲得積分</th>
                            <th scope="col">獲得金幣</th>
                            <th scope="col">獲得獎品</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach((array)$lottery as $row) :
                            $i++;
                        ?>
                        <tr>
                            <th scope="row"><?=$i?></th>
                            <td><a href="<?=BASEPATH?>/member/<?=$row['memberID']?>" target="_blank"><?=$row['nickName']?></a></td>
                            <td><?=$row['points']?></td>
                            <td><?=$row['coin']?></td>
                            <td><?=$row['item']?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>
    <?php endif; ?>

    <div class="topicList">
        <?php if ($page == 1) : ?>
        <div class="topicBody">
            <div class="row">
                <div class="col-md-2 member d-none d-md-block">
                    <p>
                        查看 &nbsp; <?=$topicData['views']?> &nbsp;&nbsp;
                        回覆 &nbsp; <?=$topicData['replies']?>
                    </p>
                    
                    <h4><a href="<?=BASEPATH?>/member/<?=$topicData['memberID']?>" target="_blank"><?=$topicData['nickName']?></a></h4>

                    <p class="imgbox">
                        <?php if ($topicData['avatar'] != '') : ?>
                        <img src="<?=BASEPATH?>/upload/avatar/<?=$topicData['avatar']?>">
                        <?php else : ?>
                        <img src="<?=BASEPATH?>/images/avatar.jpg">
                        <?php endif; ?>
                    </p>

                    <div class="row text-center infoNum">
                        <div class="col-md-4">
                            <?=$topicData['memberPosts']?><br />主題
                        </div>

                        <div class="col-md-4">
                            <?=$topicData['memberReplies']?><br />帖子
                        </div>

                        <div class="col-md-4">
                            <?=$topicData['memberPoints']?><br />積分
                        </div>
                    </div>

                    <p class="memberTitle">新手上路</p>
                    <p class="star"><i class="far fa-star"></i></p>

                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <p class="point">積分 &nbsp; <?=$topicData['memberPoints']?></p>

                    <?php if (isset($_SESSION['nsf_member']['memberID']) && ($_SESSION['nsf_member']['memberID'] == $topicData['memberID'] || $_SESSION['nsf_member']['admin'] == 1)) : ?>
                    <p class="send"><button type="button" class="btn" onclick="topicEdit();"><i class="fas fa-edit"></i> &nbsp; 編輯</button></p>
                    <?php endif; ?>

                    <!-- <p class="send"><button type="button" class="btn"><i class="far fa-envelope-open"></i> &nbsp; 發訊息</button></p> -->
                </div>

                <div class="col-md-10 article">
                    <h1>
                        [<?=$boardData['title']?>] <?=$topicData['title']?> 
                        <small>[<a href="<?=BASEPATH?>/topic/<?=$topicData['topicID']?> ">複製連結</a>]</samll>
                    </h1>

                    <div class="row info">
                        <div class="col-md-9">
                            <p>發表於 <?=$showDate?> &nbsp; <!-- | &nbsp; <a href="#">只看該作者</a> --></p>
                        </div>
                        <div class="col-md-3 text-right">
                            <p>樓主</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 content">
                            <?php
                            $parser = new \SBBCodeParser\Node_Container_Document();
                            echo $parser->parse($topicData['content'])->get_html();
                            ?>
                        </div>

                        <?php if (! is_null($topicData['lastEditTime']) && ! empty($topicData['lastEditTime'])) : ?>
                        <div class="col-md-12 edit text-right">
                        最後編輯於 <?=date('Y-m-d H:i', strtotime($topicData['lastEditTime']))?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row function">
                <div class="col-md-2"></div>
                <div class="col-md-8 interactive">
                    <a onclick="goReply();"><i class="far fa-comment-dots"></i> 回覆</a> &nbsp; 
                    <a class="awesome <?=(! is_null($review) && $review == 1) ? 'text-success font-weight-bold' : ''?>" onclick="topicReview(1);"><i class="far fa-thumbs-up"></i> 支持</a> &nbsp; 
                    <a class="trample <?=(! is_null($review) && $review == 0) ? 'text-danger font-weight-bold' : ''?>" onclick="topicReview(0);"><i class="far fa-thumbs-down"></i> 反對</a> &nbsp; 
                    <a class="collection <?=($collection == 1) ? 'text-warning font-weight-bold' : ''?>" onclick="topicCollection();"><i class="fas fa-star"></i> 收藏</a>
                </div>
                <div class="col-md-2 text-right">
                    <!-- <i class="fas fa-exclamation-triangle"></i> 舉報 -->
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php
        $floorStart = ($replies['page'] - 1) * $replies['per'];
        $i = 1;

        foreach ((array)$replies['list'] as $row) : 
            $showDate = '';

            if (date('Y-m-d') == date('Y-m-d', strtotime($row['postTime']))) {
                if (time() - strtotime($row['postTime']) <= 3600) {
                    $showDate = floor((time() - strtotime($row['postTime'])) / 60).'分鐘前';
                } else if (time() - strtotime($row['postTime']) <= 43200) {
                    $showDate = floor((time() - strtotime($row['postTime'])) / 3600).'小時前';
                } else {
                    $showDate = '今天 '.date('H:i', strtotime($row['postTime']));
                }
            } else if (date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($row['postTime']))) {
                $showDate = '昨天 '.date('H:i', strtotime($row['postTime']));
            } else {
                $showDate = date('Y-n-j', strtotime($row['postTime']));
            }
        ?>
        <div class="reply">
            <div class="row">
                <div class="col-md-2 member d-none d-md-block">                    
                    <h4><a href="<?=BASEPATH?>/member/<?=$row['memberID']?>" target="_blank"><?=$row['nickName']?></a></h4>

                    <p class="imgbox">
                        <?php if ($row['avatar'] != '') : ?>
                        <img src="<?=BASEPATH?>/upload/avatar/<?=$row['avatar']?>">
                        <?php else : ?>
                        <img src="<?=BASEPATH?>/images/avatar.jpg">
                        <?php endif; ?>
                    </p>

                    <div class="row text-center infoNum">
                        <div class="col-md-4">
                            <?=$row['memberPosts']?><br />主題
                        </div>

                        <div class="col-md-4">
                            <?=$row['memberReplies']?><br />帖子
                        </div>

                        <div class="col-md-4">
                            <?=$row['memberPoints']?><br />積分
                        </div>
                    </div>

                    <p class="memberTitle">新手上路</p>
                    <p class="star"><i class="far fa-star"></i></p>

                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <p class="point">積分 &nbsp; <?=$row['memberPoints']?></p>
                    <p class="send"><button type="button" class="btn"><i class="far fa-envelope-open"></i> &nbsp; 發訊息</button></p>
                </div>

                <div class="col-md-10 article">
                    <div class="row info">
                        <div class="col-md-9">
                            <p>發表於 <?=$showDate?> &nbsp; <!-- | &nbsp; <a href="#">只看該作者</a> --></p>
                        </div>
                        <div class="col-md-3 text-right">
                            <p class="floor">
                                <?=($floorStart + $i == 1) ? '沙發' : '#'.($floorStart + $i)?>

                                <?php if ($memberIdentity > 1) : ?>
                                <input type="checkbox" class="form-check-input" name="replies[]" value="<?=$row['topicID']?>" />
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 content">
                            <?php
                            $parser = new \SBBCodeParser\Node_Container_Document();
                            echo $parser->parse($row['content'])->get_html();
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row function">
                <div class="col-md-2"></div>
                <div class="col-md-8 interactive">
                    <i class="far fa-comment-dots"></i> 回覆 &nbsp; 
                    <i class="far fa-thumbs-up"></i> 支持 &nbsp; 
                    <i class="far fa-thumbs-down"></i> 反對 &nbsp; 
                    <i class="fas fa-star"></i> 收藏
                </div>
                <div class="col-md-2 text-right">
                    <!-- <i class="fas fa-exclamation-triangle"></i> 舉報 -->
                </div>
            </div>
        </div>
        <?php
            $i++;
        endforeach; 
        ?>
    </div>

    <div class="post">
        <div class="row board_nav  d-none d-md-flex">
            <div class="col-md-3">
                <button type="button" class="btn post_btn" onclick="goPost();">發 帖 &nbsp; <i class="fas fa-caret-down"></i></button>
            </div>

            <div class="col-md-9">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="<?=BASEPATH?>/board/c<?=$categoryID?>/b<?=$boardID?>"><i class="fas fa-caret-left"></i> &nbsp; 返回列表</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <?php if (isset($_SESSION['nsf_member']['memberID']) && ! empty($_SESSION['nsf_member']['memberID'])) : ?>
        <div class="row editor_line">
            <div class="col-md-2"></div>

            <div class="col-md-10">
                <textarea id="editor"><?=(isset($reply)) ? $reply : ''?></textarea>
            </div>
        </div>

        <div class="row reply_line">
            <div class="col-md-2"></div>

            <div class="col-md-10">
                <button type="button" class="btn" onclick="replyPost();">發表回覆</button> 
                <label><input type="checkbox" class="form-control" id="returnLastPage" /> 回帖後跳轉到最後一頁</label>
                <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
