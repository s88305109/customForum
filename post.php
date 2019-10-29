<?php
require(dirname(__FILE__).'/core/init.php');
		
class c_post
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }

	function topicPost() {
		$boardID = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;
		$title   = (isset($_REQUEST['title'])) ? $_REQUEST['title'] : '';
		$content = (isset($_REQUEST['content'])) ? $_REQUEST['content'] : '';
		$topicID = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : 0;
		$reply   = (isset($_REQUEST['reply'])) ? $_REQUEST['reply'] : 0;

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		exit('尚未登入會員');
    	}

		$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

		if (empty($topicID) && $_SESSION['nsf_member']['admin'] == 0 && ! Post::postIntervalCheck($_SESSION['nsf_member']['memberID']))
			exit('發文間隔時間不可小於60秒');

		if (! empty($topicID)) {
			if ($reply == 1)
				$topicData = Topic::getReplyData($topicID);
			else
				$topicData = Topic::getTopicData($topicID);
			
			$memberIdentity = Manage::getMemberIdentity($topicData['boardID']);

			if (empty($topicData) || ! isset($_SESSION['nsf_member']['memberID']) || ($_SESSION['nsf_member']['memberID'] != $topicData['memberID'] && $_SESSION['nsf_member']['admin'] == 0 && $memberIdentity <= 0)) {
				exit('您無權限編輯此文章');
			}
		}

		if ((empty($topicID) || $topicData['reply'] == 0) && empty($boardID))
			exit('請選擇文章分類');
		else if (trim($title) == '')
			exit('請輸入主題');
		else if (trim($content) == '')
			exit('請輸入文章內容');
		else if ($memberInfo['admin'] != 1 && $memberInfo['level'] <= 0)
			exit('您的會員等級尚無發表文章的權限');

		Post::topicPost($boardID, $title, $content, $topicID);

		echo 'OK';
	}

	function replyPost() {
		$topicID        = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : '';
		$content        = (isset($_REQUEST['content'])) ? $_REQUEST['content'] : '';
		$returnLastPage = (isset($_REQUEST['returnLastPage']) && $_REQUEST['returnLastPage'] == 'true') ? 1 : 0;

		$result['msg'] = '';

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
    		$result['msg'] = '尚未登入會員';
    		echo json_encode($result, JSON_UNESCAPED_UNICODE);
    		exit;
    	}

    	if ($_SESSION['nsf_member']['admin'] == 0 && ! Post::postIntervalCheck($_SESSION['nsf_member']['memberID'])) {
    		$result['msg'] = '發文間隔時間不可小於60秒';
    		echo json_encode($result, JSON_UNESCAPED_UNICODE);
    		exit;
    	}

		$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

		if (trim($content) == '')
			$result['msg'] = '請輸入文章內容';
		else if ($memberInfo['admin'] != 1 && $memberInfo['level'] <= 0)
			$result['msg'] = '您的會員等級尚無回覆文章的權限';

		if ($result['msg'] == '') {
			Post::replyPost($topicID, $content);

			$result['msg']        = 'OK';
			$result['returnPage'] = (! $returnLastPage) ? 1 : Topic::getRepliesTotalPages($topicID);
		}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	function saveDraft() {
		$boardID   = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : NULL;
		$subjectID = (isset($_REQUEST['subjectID'])) ? $_REQUEST['subjectID'] : NULL;
		$topicID   = (isset($_REQUEST['topicID'])) ? $_REQUEST['topicID'] : NULL;
		$title     = (isset($_REQUEST['title'])) ? $_REQUEST['title'] : '';
		$content   = (isset($_REQUEST['content'])) ? $_REQUEST['content'] : '';

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']) || ! empty($topicID) || trim($content) == '') {
    		exit();
    	}

		Post::saveDraft($boardID, $subjectID, $title, $content);
	}

	function uploader() {
		$uploader = (isset($_FILES['uploader'])) ? $_FILES['uploader'] : NULL;

		$res['result'] = '';
		$res['msg']    = '';
		$res['image']  = '';

		$allowTypes = array('image/gif', 'image/jpeg', 'image/png');

		if ($uploader['error'] != 0) {
			$res['result'] = 'fail';
			$res['msg'] = '檔案上傳失敗';
		} else if((! in_array($uploader['type'], $allowTypes))) {
			$res['result'] = 'fail';
			$res['msg'] = '僅允許上傳jpg, gif, png格式';
		} else {
			$url = 'http://'.$_SERVER['SERVER_NAME'].BASEPATH.'/upload/attachment/'.date('Y').'/';
			$path = dirname(__FILE__).'/upload/attachment/'.date('Y').'/';

			if (! file_exists($path)) {
				mkdir($path);
			}

			$extension = pathinfo($uploader['name'], PATHINFO_EXTENSION);

			do {
				$filename = uniqid().rand(1000, 9999).'.'.$extension;
			} while(file_exists($path.$filename));

			if (move_uploaded_file($uploader['tmp_name'], $path.$filename)) {
				COMMON::imageResize($path.$filename, 900, NULL);

				$res['result'] = 'success';
				$res['msg']    = '';
				$res['image']  = $url.$filename;
			}
		}

		echo json_encode($res, JSON_UNESCAPED_UNICODE);
	}

}
