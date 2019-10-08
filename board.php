<?php
require(dirname(__FILE__).'/core/init.php');

class c_board
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }
    
	function index() {
		$categoryID = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : 0;
		$boardID    = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;
		$page       = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 1;

		$categoryData   = Board::getCategoryData($categoryID);
		$categoryBoards = Board::getCategoryBoards($categoryID);
		$boardData      = Board::getBoardData($boardID);

		if (empty($categoryData)) {
			header('Location: /404');
			exit;
		} else if (! empty($boardID) && (empty($boardData) || $boardData['categoryID'] != $categoryID)) {
			header('Location: /404');
			exit;
		}

		$topics                     = Board::getBoardTopics($categoryID, $boardID, $page);
		$memberIdentity             = Manage::getMemberIdentity($boardID);
		$setManageDefaultCategoryID = 4;
		$setManageDefaultBoardID    = 0;
		$activeCategory             = Manage::getActiveCategory();
		$activeBoard                = Manage::getActiveBoard($setManageDefaultCategoryID);
		
		include('views/common/head.php');
		include('views/board/board.php');
		include('views/common/foot.php');
	}

	function post() {
		$categoryID = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : 0;
		$boardID    = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;

		$categoryData   = Board::getCategoryData($categoryID);
		$categoryBoards = Board::getCategoryBoards($categoryID);
		$boardData      = Board::getBoardData($boardID);

		if (empty($categoryData)) {
			header('Location: /404');
			exit;
		} else if (! empty($boardID) && (empty($boardData) || $boardData['categoryID'] != $categoryID)) {
			header('Location: /404');
			exit;
		} else if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		header('Location: '.BASEPATH.'/login');
			exit;
    	}

		$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

		$draft = Post::findDraft($boardID, NULL);

		if(! empty($draft)) {
			$title = $draft['title'];
			$content = $draft['content'];
		}

		include('views/common/head.php');
		include('views/board/post.php');
		include('views/common/foot.php');
	}

	function topicEdit() {
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;

		$topicData = Topic::getTopicData($topicID);

		if (empty($topicData) || ! isset($_SESSION['nsf_member']['memberID']) || $_SESSION['nsf_member']['memberID'] != $topicData['memberID']) {
			header('Location: /404');
			exit;
		}

		$categoryData   = Board::getCategoryData($topicData['categoryID']);
		$categoryBoards = Board::getCategoryBoards($topicData['categoryID']);
		$boardData      = Board::getBoardData($topicData['boardID']);

		$categoryID = $topicData['categoryID'];
		$boardID = $topicData['boardID'];

		if (empty($categoryData)) {
			header('Location: /404');
			exit;
		} else if (! empty($boardID) && (empty($boardData) || $boardData['categoryID'] != $categoryID)) {
			header('Location: /404');
			exit;
		}

		$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

		$title = $topicData['title'];
		$content = $topicData['content'];

		include('views/common/head.php');
		include('views/board/post.php');
		include('views/common/foot.php');
	}

	function loadBoards() {
		$selectCategory = (isset($_REQUEST['selectCategory'])) ? $_REQUEST['selectCategory'] : 1;

		$activeBoard = Manage::getActiveBoard($selectCategory);

		foreach ((array)$activeBoard as $row) {
        	echo "<option value=\"{$row['boardID']}\" title=\"{$row['description']}\" >{$row['title']}</option>";
        }
	}

}
