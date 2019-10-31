<?php
require(dirname(__FILE__).'/core/init.php');

class c_member
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }
    
	function index() {
		require(dirname(__FILE__).'/libraries/SBBCodeParser/SBBCodeParser.php');
		
		$memberID = (isset($_REQUEST['memberID'])) ? $_REQUEST['memberID'] : 0;

		$memberInfo = Member::getMemberInfo($memberID);

		if (empty($memberInfo)) {
			header('Location: /404');
			exit;
		}

		$memberRecentPosts = Member::getMemberRecentPosts($memberID);
		
		include('views/common/head.php');
		include('views/member/member.php');
		include('views/common/foot.php');
	}

	function avatar() {
		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']))
    		exit('尚未登入會員');

    	$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

		include('views/common/head.php');
		include('views/member/avatar.php');
		include('views/common/foot.php');
	}

	function sendVailMail() {
		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']))
    		exit('尚未登入會員');

    	$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);

    	if ($memberInfo['level'] != 1)
    		exit('您的會員信箱已驗證完成');

    	MEMBER::sendVailMail();

    	echo 'OK';
	}

	function verification() {
		$uid  = (isset($_REQUEST['uid'])) ? $_REQUEST['uid'] : '';
		$code = (isset($_REQUEST['code'])) ? $_REQUEST['code'] : '';

		$content = Member::verification($uid, $code);

		exit('<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><title>欣亞數位會員信箱驗證</title></head><body>'.$content.'</body></html>');
	}

	function uploadPic() {
		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID']))
    		exit('尚未登入會員');

		if (! isset($_FILES['pic']) || $_FILES['pic']['name'] == '')
			exit('請選擇要上傳的頭像圖片');

		$ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);

		do {
			$filename = uniqid();
		} while(file_exists('upload/avatar/'.$filename.$ext));

		if (move_uploaded_file($_FILES['pic']['tmp_name'], 'upload/avatar/'.$filename.'.'.$ext)) {
			Common::imageResize('upload/avatar/'.$filename.'.'.$ext, 150, 150);
			$avatarFilename = $filename.'.'.$ext;
			Member::updateAvatar($avatarFilename);

			echo 'OK';
		} else {
			echo '圖片上傳失敗';
		}
	}

	function exchange() {
		$pay = (isset($_REQUEST['pay'])) ? $_REQUEST['pay'] : NULL;

		$result['result'] = '';

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
			$result['result'] = 'fail';
			$result['msg']    = '尚未登入會員';
    	} else if (empty($pay) || $pay <= 0 || ! is_numeric($pay)) {
    		$result['result'] = 'fail';
			$result['msg']    = '請輸入要兌換的金幣數量';
    	}

    	if ($result['result'] == '') {
			$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);
			$coin       = isset($memberInfo['coin']) ? $memberInfo['coin'] : 0;
			$unit       = 30;

			if ($coin < $pay || $pay < $unit) {
				$result['result'] = 'fail';
				$result['msg']    = '您的剩餘金幣不足';
			} else {
				$money = floor($pay / $unit);
				$pay2  = $money * $unit;

				$result['result'] = 'success';
				$result['msg']    = "請問是否確定要支付 {$pay2} 點金幣來兌換 {$money} 點欣台幣？";
				$result['pay']    = $pay2;
			}
    	}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	function exchange2() {
		$pay = (isset($_REQUEST['pay'])) ? $_REQUEST['pay'] : NULL;

		$result['result'] = '';

		if (! isset($_SESSION['nsf_member']['memberID']) || empty($_SESSION['nsf_member']['memberID'])) {
			$result['result'] = 'fail';
			$result['msg']    = '尚未登入會員';
    	} else if (empty($pay) || $pay <= 0 || ! is_numeric($pay)) {
    		$result['result'] = 'fail';
			$result['msg']    = '請輸入要兌換的金幣數量';
    	}

    	if ($result['result'] == '') {
			$memberInfo = Member::getMemberInfo($_SESSION['nsf_member']['memberID']);
			$coin       = isset($memberInfo['coin']) ? $memberInfo['coin'] : 0;
			$unit       = 30;

			if ($coin < $pay || $pay < $unit) {
				$result['result'] = 'fail';
				$result['msg']    = '您的剩餘金幣不足';
			} else {
				$money = floor($pay / $unit);
				$pay2  = $money * $unit;

				Member::exchangeSinyaCoupon($_SESSION['nsf_member']['memberID'], $money, $unit);

				$result['result'] = 'success';
				$result['msg']    = 'OK';
			}
    	}

		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

}
