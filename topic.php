<?php
require(dirname(__FILE__).'/core/init.php');

class c_topic
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }
    
	function topic() {
		require(dirname(__FILE__).'/libraries/SBBCodeParser/SBBCodeParser.php');

		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;

		$topicData = Topic::getTopicData($topicID);

		if (empty($topicData)) {
			header('Location: /404');
			exit;
		}

		Topic::topicView($topicID);
		
		$page       = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$replies    = Topic::getReplies($topicID, $page);
		$review     = Topic::getReview($topicID);
		$collection = Topic::getCollection($topicID);
		$lottery    = Topic::getLottery($topicID);

		if ($page > 1 && empty($replies['list'])) {
			header('Location: /404');
			exit;
		}

		$categoryID                 = $topicData['categoryID'];
		$boardID                    = $topicData['boardID'];
		$categoryData               = Board::getCategoryData($topicData['categoryID']);
		$boardData                  = Board::getBoardData($topicData['boardID']);
		$memberIdentity             = Manage::getMemberIdentity($topicData['boardID']);
		$setManageDefaultCategoryID = 4;
		$setManageDefaultBoardID    = 0;
		$activeCategory             = Manage::getActiveCategory();
		$activeBoard                = Manage::getActiveBoard($setManageDefaultCategoryID);

		$showDate = '';

        if (date('Y-m-d') == date('Y-m-d', strtotime($topicData['postTime']))) {
            if (time() - strtotime($topicData['postTime']) <= 3600) {
                $showDate = floor((time() - strtotime($topicData['postTime'])) / 60).'分鐘前';
            } else if (time() - strtotime($topicData['postTime']) <= 43200) {
                $showDate = floor((time() - strtotime($topicData['postTime'])) / 3600).'小時前';
            } else {
                $showDate = '今天 '.date('H:i', strtotime($topicData['postTime']));
            }
        } else if (date('Y-m-d', strtotime('-1 days')) == date('Y-m-d', strtotime($topicData['postTime']))) {
            $showDate = '昨天 '.date('H:i', strtotime($topicData['postTime']));
        } else {
            $showDate = date('Y-n-j', strtotime($topicData['postTime']));
        }

        $draft = Post::findDraft(NULL, $topicID);

        if(! empty($draft)) {
			$reply = $draft['content'];
		}
		
		include('views/common/head.php');
		include('views/topic/topic.php');
		include('views/common/foot.php');
	}

	function ubb2html($content, $nl2br = true) {
		//匹配模式
		$pattern = array(
			"/\[b\](.*)\[\/b\]/is",
			"/\[u\](.*)\[\/u\]/is",
			"/\[i\](.*)\[\/i\]/is",
			"/\[quote\](.*)\[\/quote\]/is",
			"/\[color=([^\[\<]+?)\](.*)\[\/color\]/is",
			"/\[font=([^\[\<]+?)\](.*)\[\/font\]/is",
			"/\[size=(\d+?)\](.*)\[\/size\]/is",
			"/\[url\](.*)\[\/url\]/i",
			"/\[url=(.*)\](.*)\[\/url\]/i",
			"/\[flash=(\d+),(\d+)\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/i",
			"/\[swf\]\s*([^\[\<\r\n]+?)\s*\[\/swf\]/i",
			"/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/i",
			);

		//替换格式
		$replacement = array(
			"<b>\\1</b>",
			"<u>\\1</u>",
			"<i>\\1</i>",
			"<blockquote>\\1</blockquote>",
			"<font color=\"\\1\">\\2</font>",
			"<font face=\"\\1\">\\2</font>",
			"<font size=\"\\1\">\\2</font>",
			"<a href=\"\\1\" target=\"_blank\">\\1</a>",
			"<a href=\"\\1\" target=\"_blank\">\\2</a>",
			"<p><embed width=\"\\1\" height=\"\\2\" src=\"\\3\"></embed></p>",
			"<p><embed width=\"500\" height=\"400\" src=\"\\1\"></embed></p>",
			"<a href=\"\\1\" target=\"_blank\"><img src=\"\\1\" alt=\"\\1\" border=\"0\" /></a>",
			);

		//针对$content字符串进行$pattern规则的正则匹配并替换为$replacement所定义的格式
		//可自行定义更多规则，保证一一对应就行了
		$content = preg_replace($pattern, $replacement, $content);

		//(不)换行, \n convert to <br />
		$content = $nl2br === true ? nl2br($content) : $content;

		return $content;
	}

	function topicReview() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;
		$review  = (isset($_REQUEST['review'])) ? $_REQUEST['review'] : 1;

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		exit('尚未登入會員');
    	}

    	Topic::topicReview($topicID, $review);

		echo 'OK';
	}

	function topicCollection() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		exit('尚未登入會員');
    	}

    	Topic::topicCollection($topicID);

		echo 'OK';
	}

	function topicDelete() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		exit('尚未登入會員');
    	}

    	$topicData = Topic::getTopicData($topicID);

		if (empty($topicData) || $topicData['memberID'] != $_SESSION['nsf_member']['memberID']) {
			exit('查無文章資料');
		}

    	Topic::topicDelete($topicID);

		echo 'OK';
	}

	function replyDelete() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		exit('尚未登入會員');
    	}

    	$replyData = Topic::getReplyData($topicID);

		if (empty($replyData) || $replyData['memberID'] != $_SESSION['nsf_member']['memberID']) {
			exit('查無文章資料');
		}

    	Topic::topicDelete($topicID);

		echo 'OK';
	}

}
