<ul class="nav">
    <li <?php if ($_SERVER['REQUEST_URI'] == BASEPATH.'/admin/forumManage') echo 'class="active"'; ?>>
        <a href="<?=BASEPATH?>/admin/forumManage">版面管理</a>
    </li>
    <li <?php if ($_SERVER['REQUEST_URI'] == BASEPATH.'/admin/bannerManage') echo 'class="active"'; ?>>
        <a href="<?=BASEPATH?>/admin/bannerManage">橫幅廣告管理</a>
    </li>
    <li <?php if ($_SERVER['REQUEST_URI'] == BASEPATH.'/admin/announcementManage') echo 'class="active"'; ?>>
        <a href="<?=BASEPATH?>/admin/announcementManage">公告管理</a>
    </li>
    <li <?php if ($_SERVER['REQUEST_URI'] == BASEPATH.'/admin/searchManage') echo 'class="active"'; ?>>
        <a href="<?=BASEPATH?>/admin/searchManage">熱搜管理</a>
    </li>
</ul>