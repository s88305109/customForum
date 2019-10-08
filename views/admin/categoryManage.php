<style>
.alert, .memberCard {
    display: none;
}

.table td, .table th {
    vertical-align: middle;
}
</style>
<script type="text/javascript">
function saveSetting() {
    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/categorySave', $('#frm').serialize(), function(result) {
        if (result != 'OK') {
            $('.alert .content').html(result);
            $('.alert').fadeIn();
        } else {
            window.location.href = '<?=BASEPATH?>/admin/forumManage';
        }
    });
}

function memberSearch() {
    $('.alert').hide();

    $.post('<?=BASEPATH?>/admin/memberSearch', { email : $('#email').val() }, function(result) {
        if (result.msg != 'OK') {
            $('.alert .content').html(result.msg);
            $('.alert').fadeIn();
        } else {
            $('.memberCard .card-body').html('<h5 class="card-title">會員搜尋</h5><b>帳號：</b>' + result.email + ' | <b>暱稱：</b>' + result.nickName + ' | <input type="hidden" id="appointMemberID" value="' + result.memberID + '" data-email="' + result.email + '" data-nickname="' + result.nickName + '" /> <button type="button" class="btn btn-success appoint" onclick="appoint();">任命分區版主</button>');
            $('.memberCard').show();
        }
    }, 'json');
}

function appoint() {
    if ($('input[name="moderators[]"][value="' + $('#appointMemberID').val() + '"]').length > 0) {
        return false;
    }

    $('.moderators .empty').hide();
    $('.moderators').append('<tr><td class="text-center"><button type="button" class="btn btn-danger" onclick="removeModerator(this);">移除</button><input type="hidden" name="moderators[]" value="' + $('#appointMemberID').val() + '" /></td><td>' + $('#appointMemberID').data('email') + '</td><td>' + $('#appointMemberID').data('nickname') + '</td></tr>');
}

function removeModerator(obj) {
    $(obj).parents('tr').remove();

    if ($('input[name="moderators[]"]').length == 0) {
        $('.moderators .empty').show();
    }
}
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
    	<nav aria-label="breadcrumb">
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
    			<li class="breadcrumb-item active" aria-current="page">版面管理</li>
                <li class="breadcrumb-item active" aria-current="page">分類設定</li>
    		</ol>
    	</nav>
    </div>
</div>

<div class="container">
    <div class="row news">
		<h3>分類設定</h3>

        <div class="col-md-12 col-sm-12">
            <div class="alert alert-warning">
                <a href="#" class="close" onclick="$('.alert').fadeOut();">&times;</a>
                <strong class="content"></strong>
            </div>

            <form id="frm">
                <input type="hidden" name="categoryID" value="<?=$categoryID?>" />

                <div class="form-group">
                    <label for="title">分類標題</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?=(isset($category['title'])) ? $category['title'] : ''?>" />
                </div>

                <div class="form-group">
                    <label for="description">描述</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?=(isset($category['description'])) ? $category['description'] : ''?></textarea>
                </div>

                <div class="form-group">
                    <label class="mr-4">顯示於列表</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="visible0" name="visible" value="0" <?php if (! isset($category['visible']) || $category['visible'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="visible0">隱藏</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="visible1" name="visible" value="1" <?php if (isset($category['visible']) && $category['visible'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="visible1">顯示</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="mr-4">狀態　　　</label>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status0" name="status" value="0" <?php if (! isset($category['status']) || $category['status'] == 0) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status0">停用</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="status1" name="status" value="1" <?php if (isset($category['status']) && $category['status'] == 1) echo 'checked="checked"'; ?> />
                        <label class="custom-control-label" for="status1">啟用</label>
                    </div>
                </div>

                <div class="form-inline">
                    <label for="email">請輸入會員Email帳號：</label>
                    <input type="text" class="form-control" id="email" name="email" value="" size="40" /> &nbsp;&nbsp;
                    <button type="button" class="btn" onclick="memberSearch();">搜尋</button>
                </div>

                <div class="memberCard card mt-4">
                    <div class="card-body"></div>
                </div>

                <div class="mt-4 row">
                    <h3>分區版主</h3>

                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">帳號</th>
                                    <th scope="col">會員暱稱</th>
                                </tr>
                            </thead>
                            <tbody class="moderators">
                                <tr class="empty" <?=(isset($moderators) && ! empty($moderators) && count($moderators) > 0) ? 'style="display:none;"' : '' ?>>
                                    <td class="text-center" colspan="3">尚無任何版主</td>
                                </tr>

                                <?php
                                if (isset($moderators) && ! empty($moderators) && count($moderators) > 0) {
                                    foreach((array) $moderators as $row) {
                                        echo '<tr>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger" onclick="removeModerator(this);">移除</button>
                                                <input type="hidden" name="moderators[]" value="'.$row['memberID'].'" />
                                            </td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['nickName'].'</td>
                                        </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
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
