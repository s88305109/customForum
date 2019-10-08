<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
if (isset($topicData) && isset($topicData['title']) && isset($topicData['content'])) {
	$topicContent = preg_replace('|[[\/\!]*?[^\[\]]*?]|si', '', $topicData['content']);
	$topicContent = str_replace(array("\r\n", "\r", "\n", "\t"), array('', '', '', ''), $topicContent);
	$metaTitle = $topicData['title']. ' - 欣亞數位論壇 欣亞數位電腦 欣亞排排購';
	$metaDescription = mb_substr($topicContent,0, 150, 'UTF-8');
} else if (isset($boardData) && isset($boardData['title']) && isset($boardData['description'])) {
	$metaTitle = $boardData['title']. ' - 欣亞數位論壇 欣亞數位電腦 欣亞排排購';
	$metaDescription = str_replace(array("\r\n", "\r", "\n", "\t"), array('', '', '', ''), $boardData['description']);
} else {
	$metaTitle = '欣亞數位論壇 欣亞數位電腦 欣亞排排購';
	$metaDescription = '欣亞優惠發布,開箱評測,新品資訊,與欣亞聯絡';
}
?>

<title><?=$metaTitle?></title>
<meta name="description" content="<?=$metaDescription?>">
<meta name="keywords" content="欣亞,欣亞電腦,欣亞數位">

<meta property="og:title" content="<?=$metaTitle?>" >
<meta property="og:description" content="<?=$metaDescription?>" >

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

<!-- fontawesome CSS -->
<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>

<link rel="stylesheet"  type="text/css" href="<?=BASEPATH?>/css/reset.css">
<link rel="stylesheet/less"  type="text/css" href="<?=BASEPATH?>/css/main.less">
<script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</head>
<body>
