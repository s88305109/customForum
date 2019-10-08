<?php
require(dirname(__FILE__).'/core/init.php');

class c_manage
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }
    
	function manageBatchMoveTopics() {
		$topicIDs    = (isset($_REQUEST['topicIDs'])) ? $_REQUEST['topicIDs'] : array();
		$boardID     = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;
		$selectBoard = (isset($_REQUEST['selectBoard'])) ? $_REQUEST['selectBoard'] : 0;

		$memberIdentity = Manage::getMemberIdentity($boardID);

		if ($memberIdentity < 1) {
			exit('您無權限管理此看板');
		} else if (empty($selectBoard) || $selectBoard == 'null') {
			exit('請選擇搬移的目標看板');
		} else if (empty($topicIDs) || count($topicIDs) == 0) {
			exit('請選取要移動的主題');
		}

		Manage::manageBatchMoveTopics($boardID, $topicIDs, $selectBoard);

		echo 'OK';
	}

	function manageSetTopicTop() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;
		$top     = (isset($_REQUEST['top'])) ? $_REQUEST['top'] : 0;

		$topicData = Topic::getTopicData($topicID);

		if (empty($topicData)) {
			exit('查無主題資料');
		}

		$memberIdentity = Manage::getMemberIdentity($topicData['boardID']);

		if ($memberIdentity < 1) {
			exit('您無權限管理此看板');
		}

		Manage::manageSetTopicTop($topicID, $top);

		echo 'OK';
	}

	function manageBatchDelTopics() {
		$topicIDs = (isset($_REQUEST['topicIDs'])) ? $_REQUEST['topicIDs'] : array();
		$boardID  = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;
		$cause    = (isset($_REQUEST['cause'])) ? $_REQUEST['cause'] : 0;

		$memberIdentity = Manage::getMemberIdentity($boardID);

		if ($memberIdentity < 1) {
			exit('您無權限管理此看板');
		} else if (empty($topicIDs) || count($topicIDs) == 0) {
			exit('請選取要刪除的主題');
		}

		Manage::manageBatchDelTopics($boardID, $topicIDs, $cause);

		echo 'OK';
	}

	function manageBatchDelReplies() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;
		$replies = (isset($_REQUEST['replies'])) ? $_REQUEST['replies'] : array();

		$topicData  = Topic::getTopicData($topicID);

		if (empty($topicData)) {
			exit('查無主題資料');
		}

		$memberIdentity = Manage::getMemberIdentity($topicData['boardID']);

		if ($memberIdentity < 1) {
			exit('您無權限管理此看板');
		} else if (empty($replies) || count($replies) == 0) {
			exit('請選取要刪除的回覆');
		}

		Manage::manageBatchDelReplies($topicData['topicID'], $replies);

		echo 'OK';
	}

	function lottery() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;
		$number  = (isset($_REQUEST['number'])) ? $_REQUEST['number'] : array();
		$points  = (isset($_REQUEST['points'])) ? $_REQUEST['points'] : array();
		$coin    = (isset($_REQUEST['coin'])) ? $_REQUEST['coin'] : array();
		$item    = (isset($_REQUEST['item'])) ? $_REQUEST['item'] : array();

		$topicData = Topic::getTopicData($topicID);

		if (empty($topicData)) {
			exit('查無主題資料');
		}

		$memberIdentity = Manage::getMemberIdentity($topicData['boardID']);

		if ($memberIdentity < 1) {
			exit('您無權限管理此看板');
		}

		Manage::lottery($topicID, $number, $points, $coin, $item);

		echo 'OK';
	}

}
