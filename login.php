<?php
require(dirname(__FILE__).'/core/init.php');

class c_login
{    

	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }

	function index () {
		require(dirname(__FILE__).'/libraries/SBBCodeParser/SBBCodeParser.php');
		
		$boards       = ForumLayout::getIndexBoards();
		$serviceBoard = ForumLayout::getServiceBoard();
		$banners      = ForumLayout::getIndexBanners();
		$latestPost   = ForumLayout::getLatestPost();
		$latestReply  = ForumLayout::getLatestReply();
		$hotPost      = ForumLayout::getHotPost();

		include('views/common/head.php');
		include('views/login/index.php');
		include('views/common/foot.php');
	}

	function memberLogin () {
		$email    = (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '';
		$password = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : '';
		$code     = (isset($_REQUEST['code'])) ? $_REQUEST['code'] : '';

		$result['result'] = 'initial';
		$result['msg']    = '';

		include_once('./libraries/securimage/securimage.php');
		$securimage = new Securimage();

		if (trim($email) == '') {
			$result['result'] = 'fail';
			$result['msg']    = '請輸入您的電子郵件地址';
	    } else if (trim($password) == '') {
			$result['result'] = 'fail';
			$result['msg']    = '請輸入您的會員密碼';
	    }  else if (trim($code) == '') {
			$result['result'] = 'fail';
			$result['msg']    = '請輸入圖片中顯示的驗證碼';
	    } else if ($securimage->check($code) == false) {
			$result['result'] = 'fail';
			$result['msg']    = '驗證碼輸入錯誤';
		}

	    if ($result['result'] == 'initial') {
	    	$login = Member::manualLogin($email, $password);

	    	if ($login) {
	    		$result['result'] = 'success';
				$result['msg']    = 'OK';
	    	} else {
	    		$result['result'] = 'fail';
				$result['msg']    = '您輸入的帳號密碼錯誤，無法登入會員。';
	    	}
	    }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	function logout() {
		$_SESSION['nsf_member']['memberID'] = '';
        $_SESSION['nsf_member']['nickName'] = '';
        $_SESSION['nsf_member']['title']    = '';
        $_SESSION['nsf_member']['admin']    = '';

        unset($_SESSION['nsf_member']);

        header('Location: '.BASEPATH.'/');
	}

}
