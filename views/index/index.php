<!-- Owl Carousel -->
<link rel="stylesheet" href="libraries/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="libraries/owl-carousel/owl.theme.css">
<script src="libraries/owl-carousel/owl.carousel.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    if($(window).width()>900){
        $('#slide-banner').owlCarousel({
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem:true,
            autoPlay : true,
            navigation : false,
        });
    }
    else{
        $('#slide-banner').owlCarousel({
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem:true,
            autoPlay : false,
            navigation : false,
            pagination:false,
        });
    }
});
</script>

<div class="container_fluid">
    <?php include(dirname(__FILE__).'/../common/header.php'); ?>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=BASEPATH?>/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">論壇首頁</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="banner_block">
        <div id="slide-banner" class="owl-carouse1">
            <?php foreach((array) $banners as $row) : ?>
            <div class="item">
                <?php if (trim($row['link']) != '') : ?>
                <a href="<?=$row['link']?>">
                <?php endif; ?>
                    <img src="<?=BASEPATH?>/upload/banner/<?=$row['filename']?>" title="<?=$row['title']?>" />
                <?php if (trim($row['link']) != '') : ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row news">
        <div class="col-md-4 col-sm-12">
            <h3 class="green2">最新貼文</h3>
            <ul>
                <?php foreach((array)$latestPost as $row) : ?>
                <li><a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>"><?=$row['title']?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-4 col-sm-12">
            <h3 class="green2">最新回覆</h3>
            <ul>
                <?php foreach((array)$latestReply as $row) : ?>
                <li>
                    <a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>/<?=$row['totalPages']?>">
                    <?php
                    $parser = new \SBBCodeParser\Node_Container_Document();
                    $content = strip_tags($parser->parse($row['content'])->get_html());

                    if (mb_strlen($content, 'UTF-8') > 20) {
                        $content = mb_substr($content, 0, 20, 'UTF-8').' ...';
                    }

                    echo $content;
                    ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-4 col-sm-12">
            <h3 class="green2">人氣熱帖</h3>
            <ul>
                <?php foreach((array)$hotPost as $row) : ?>
                <li><a href="<?=BASEPATH?>/topic/<?=$row['topicID']?>"><?=$row['title']?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <?php $i = 0; ?>
    <?php foreach ((array)$boards as $categoryID => $row) : ?>
    <div class="row">
        <div class="<?=($i == 0) ? 'col-lg-9 col-sm-12' : 'col-sm-12'?>">
            <div class="green_big_title">
                <h3 class="float-left"><?=$row['categoryTitle']?></h3>
                <h4 class="float-right">分區版主：<?=ForumLayout::getModerators($categoryID)?></h4>
            </div>

            <section class="list_dash">
                <?php foreach ((array)$row['boards'] as $row2) : ?>
                <a href="board/c<?=$categoryID?>/b<?=$row2['boardID']?>" <?=($row2['highlight']) ? 'class="red"' : ''?>>
                    <div class="name">
                        <h5><i class="<?=$row2['iconName']?>"></i><?=$row2['title']?></h5>
                        <p><?=$row2['description']?></p>
                    </div>
                    <div class="num">
                        <span><?=$row2['posts']?></span> / <span><?=$row2['responses']?></span>
                    </div>
                    <div class="time">
                        <?php
                        if (! empty($row2['lastUpdateTime'])) :
                            if (date('Y-m-d') == date('Y-m-d', strtotime($row2['lastUpdateTime'])))
                                $showDate = '今天 '.date('H:i', strtotime($row2['lastUpdateTime']));
                            else if (date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($row2['lastUpdateTime'])))
                                $showDate = '昨天 '.date('H:i', strtotime($row2['lastUpdateTime']));
                            else
                                $showDate = date('Y-n-j H:i', strtotime($row2['lastUpdateTime']));
                        ?>
                        <p>最後發表於</p>
                        <p><?=$showDate?> <?=$row2['lastUpdateNickName']?></p>
                        <?php else: ?>
                        &nbsp;
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </section>
        </div>

        <?php if ($i == 0) : ?>
            <?php foreach ((array)$serviceBoard as $categoryID => $row3) : ?>
            <div class="col-lg-3 col-sm-12">
                <div class="green_big_title">
                    <h3 class="float-left"><?=$row3['categoryTitle']?></h3>
                </div>
                <section class="list_dash">
                    <?php foreach ((array)$row3['boards'] as $row4) : ?>
                    <a href="board/c<?=$categoryID?>/b<?=$row4['boardID']?>">
                        <div>
                            <h5><i class="<?=$row4['iconName']?>"></i><?=$row4['title']?></h5>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </section>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php $i++; ?>
    <?php endforeach; ?>

    <?php include(dirname(__FILE__).'/../common/footer.php'); ?>
</div>
