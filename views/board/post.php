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

function topicPost() {
    if (loading == 1)
        return false;

    loading = 1;
    $('.topicPost').prop('disabled', true);
    $('.ajaxLoader').fadeIn();

    $.post('<?=BASEPATH?>/post/topicPost', { title : $('#title').val(), content : $('#editor').sceditor('instance').val(), boardID : $('#boardID').val() <?php if (isset($topicData)) : ?>, topicID : '<?=$topicData['topicID']?>', reply : '<?=$topicData['reply']?>'<?php endif; ?> }, function(result) {
        if (result != 'OK') {
            loading = 0;
            $('.topicPost').prop('disabled', false);
            $('.ajaxLoader').fadeOut();
            alert(result, '錯誤訊息');
        } else {
            $('.topicPost').html('文章已成功儲存');
            $('.ajaxLoader').fadeOut();

            <?php if (isset($topicData['reply']) && $topicData['reply'] == 1) : ?>
            window.location.href = '<?=BASEPATH?>/topic/<?=$topicData['subjectID']?>';
            <?php else : ?>
            window.location.href = '<?=BASEPATH?>/board/c<?=$categoryID?>/b' + $('#boardID').val();
            <?php endif; ?>
        }
    });
}

function draftHandle() {
    if (changed == 1) {
        saveDraft();
    }
}

function saveDraft() {
    if (loading == 1)
        return false;
    
    $.post('<?=BASEPATH?>/post/saveDraft', { title : $('#title').val(), content : $('#editor').sceditor('instance').val(), boardID : $('#boardID').val() <?php if (isset($topicData)) : ?>, topicID : '<?=$topicData['topicID']?>'<?php endif; ?> }, function(result) {
        changed = 0;
    });
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?=BASEPATH?>/">論壇首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$categoryData['categoryTitle']?></li>
                <?php if (isset($boardID) && ! empty($boardID) && ! empty($boardData)) : ?>
                <li class="breadcrumb-item active" aria-current="page"><?=$boardData['title']?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<div class="container board">
    <?php if (isset($boardID) && ! empty($boardID) && ! empty($boardData)) : ?>
    <div class="row board_title_line">
        <div class="col-lg-6 board_title align-middle">
            <h1>
                <i class="<?=$boardData['iconName']?>"></i>
                <?=$boardData['title']?>
                <small><?=$boardData['description']?></small>
            </h1>
        </div>

        <div class="col-lg-4 number_info"></div>

        <div class="col-lg-2 tool"></div>
    </div>
    <?php endif; ?>

    <?php if (($memberInfo['admin'] != 1 && $memberInfo['level'] <= 0) || $memberInfo['status'] != 1) : ?>
    <div class="post">
        <div class="row">
            <div class="col-12 mt-5 mb-5 text-danger text-center">您的會員等級尚無發表文章的權限</div>
        </div>
    </div>
    <?php else: ?>
    <div class="post">
        <?php if (isset($boardID) && ! empty($boardID) && ! empty($boardData)) : ?>
        <div class="row board_nav">
            <div class="col-lg-3">&nbsp;</div>

            <div class="col-lg-9">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="<?=BASEPATH?>/board/<?=$categoryID?>/<?=$boardID?>"><i class="fas fa-caret-left"></i> &nbsp; 返回列表</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($topicData) && $topicData['reply'] == 0 && (! isset($boardID) || empty($boardID) || empty($boardData))) : ?>
        <div class="mt-2 text-nowrap">
            文章分類：
            <select class="form-control category" id="boardID" name="boardID">
                <?php foreach((array)$categoryBoards as $row) : ?>
                <option value="<?=$row['boardID']?>"><?=$row['title']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php else: ?>
        <input type="hidden" id="boardID" name="boardID" value="<?=$boardID?>" />
        <?php endif; ?>

        <div class="mt-2 text-nowrap">
            <div class="form-group">
                <label for="title" class="col-form-label">　　主題：</label>
                <input type="text" class="form-control" id="title" name="title" value="<?=(isset($title)) ? $title : ''?>" <?php if (isset($topicData) &&  $topicData['reply'] == 1) echo 'readonly="readonly"'; ?> />
            </div>
        </div>

        <div class="row editor_line">
            <div class="col-lg-12">
                <textarea id="editor"><?=(isset($content)) ? $content : ''?></textarea>
            </div>
        </div>

        <div class="row reply_line">
            <div class="col-lg-12">
                <button type="button" class="btn topicPost" onclick="topicPost();"><?=isset($topicData['topicID']) && ! empty($topicData['topicID']) ? '編輯文章' : '發表文章' ?></button> 
                <img class="ajaxLoader" src="<?=BASEPATH?>/images/ajax-loader.gif" />
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
