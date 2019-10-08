<?php
require(dirname(__FILE__).'/core/init.php');

class c_admin
{
	function __construct() {
    	Member::officialWebsiteLogin();
    	Member::memberVerification();
        Admin::permissionValidation();
    }

	function forumManage() {
		$categoryData = Admin::getCategoryData();
		$boardData    = Admin::getBoardData();

		include('views/common/head.php');
		include('views/admin/forumManage.php');
		include('views/common/foot.php');
	}

	function categoryManage() {
		$categoryID = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : 0;

		if (! empty($categoryID)) {
			$category   = Admin::getCategory($categoryID);
			$moderators = Admin::getModerators($categoryID);
		}

		include('views/common/head.php');
		include('views/admin/categoryManage.php');
		include('views/common/foot.php');
	}

	function categorySave() {
		$categoryID = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : 0;

		$data['title']       = (isset($_REQUEST['title'])) ? strip_tags ($_REQUEST['title']) : '';
		$data['description'] = (isset($_REQUEST['description'])) ? strip_tags ($_REQUEST['description']) : '';
		$data['visible']     = (isset($_REQUEST['visible'])) ? $_REQUEST['visible'] : 0;
		$data['status']      = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : 0;
		$data['moderators']  = (isset($_REQUEST['moderators'])) ? $_REQUEST['moderators'] : NULL;

		if (trim($data['title']) == '')
			exit('請輸入分類標題');

		Admin::updateCategory($categoryID, $data);

		echo 'OK';
	}

	function updateCategorySort() {
		$categoryID = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : NULL;

		Admin::updateCategorySort($categoryID);

		echo 'OK';
	}

	function boardManage() {
		$boardID = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;

		if (! empty($boardID))
			$board = Admin::getBoard($boardID);

		$categoryData = Admin::getCategoryData();

		include('views/common/head.php');
		include('views/admin/boardManage.php');
		include('views/common/foot.php');
	}

	function boardSave() {
		$boardID = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : 0;

		$data['categoryID']  = (isset($_REQUEST['categoryID'])) ? $_REQUEST['categoryID'] : 0;
		$data['title']       = (isset($_REQUEST['title'])) ? strip_tags ($_REQUEST['title']) : '';
		$data['description'] = (isset($_REQUEST['description'])) ? strip_tags ($_REQUEST['description']) : '';
		$data['visible']     = (isset($_REQUEST['visible'])) ? $_REQUEST['visible'] : 0;
		$data['highlight']   = (isset($_REQUEST['highlight'])) ? $_REQUEST['highlight'] : 0;
		$data['status']      = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : 0;

		if (trim($data['title']) == '')
			exit('請輸入分類標題');

		Admin::updateBoard($boardID, $data);

		echo 'OK';
	}

	function updateBoardSort() {
		$boardID = (isset($_REQUEST['boardID'])) ? $_REQUEST['boardID'] : NULL;

		Admin::updateBoardSort($boardID);

		echo 'OK';
	}

	function bannerManage() {
		$banners = Admin::getBannerData();

		include('views/common/head.php');
		include('views/admin/bannerManage.php');
		include('views/common/foot.php');
	}

	function bannerEdit() {
		$bannerID = (isset($_REQUEST['bannerID'])) ? $_REQUEST['bannerID'] : 0;

		if (! empty($bannerID))
			$banner = Admin::getBanner($bannerID);

		include('views/common/head.php');
		include('views/admin/bannerEdit.php');
		include('views/common/foot.php');
	}

	function bannerSave() {
		$bannerID = (isset($_REQUEST['bannerID'])) ? $_REQUEST['bannerID'] : 0;

		$data['title']       = (isset($_REQUEST['title'])) ? strip_tags ($_REQUEST['title']) : '';
		$data['description'] = (isset($_REQUEST['description'])) ? strip_tags ($_REQUEST['description']) : '';
		$data['link']        = (isset($_REQUEST['link'])) ? strip_tags ($_REQUEST['link']) : '';
		$data['status']      = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : 0;
		$data['position']    = 'index';

		if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
			$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

			do {
				$filename = uniqid();
			} while(file_exists('upload/banner/'.$filename.$ext));

			if (move_uploaded_file($_FILES['image']['tmp_name'], 'upload/banner/'.$filename.'.'.$ext))
				$data['filename'] = $filename.'.'.$ext;
		}

		if (trim($data['title']) == '')
			exit('請輸入分類標題');

		Admin::updateBanner($bannerID, $data);

		echo 'OK';
	}

	function updateBannerSort() {
		$bannerID = (isset($_REQUEST['bannerID'])) ? $_REQUEST['bannerID'] : NULL;

		Admin::updateBannerSort($bannerID);

		echo 'OK';
	}

	function deleteBanner() {
		$bannerID = (isset($_REQUEST['bannerID'])) ? $_REQUEST['bannerID'] : NULL;

		Admin::deleteBanner($bannerID);

		echo 'OK';
	}

	function announcementManage() {
		$announcements = Admin::getAnnouncementData();

		include('views/common/head.php');
		include('views/admin/announcementManage.php');
		include('views/common/foot.php');
	}

	function announcementEdit() {
		$announcementID = (isset($_REQUEST['announcementID'])) ? $_REQUEST['announcementID'] : 0;

		if (! empty($announcementID))
			$announcement = Admin::getAnnouncement($announcementID);

		include('views/common/head.php');
		include('views/admin/announcementEdit.php');
		include('views/common/foot.php');
	}

	function announcementSave() {
		$announcementID = (isset($_REQUEST['announcementID'])) ? $_REQUEST['announcementID'] : 0;

		$data['title']     = (isset($_REQUEST['title'])) ? strip_tags ($_REQUEST['title']) : '';
		$data['link']      = (isset($_REQUEST['link'])) ? strip_tags ($_REQUEST['link']) : '';
		$data['startTime'] = (isset($_REQUEST['startTime'])) ? strip_tags ($_REQUEST['startTime']) : '';
		$data['endTime']   = (isset($_REQUEST['endTime'])) ? strip_tags ($_REQUEST['endTime']) : '';
		$data['status']    = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : 0;

		if (trim($data['title']) == '')
			exit('請輸入公告標題');

		Admin::updateAnnouncement($announcementID, $data);

		echo 'OK';
	}

	function deleteAnnouncement() {
		$announcementID = (isset($_REQUEST['announcementID'])) ? $_REQUEST['announcementID'] : NULL;

		Admin::deleteAnnouncement($announcementID);

		echo 'OK';
	}

	function memberSearch() {
		$email = (isset($_REQUEST['email'])) ? $_REQUEST['email'] : '';

		if (trim($email) == '') {
			$result['msg'] = '請輸入會員的Email帳號';
		} else {
			$member = Admin::memberSearch($email);

			if ($member['msg'] == 'OK') {
				$result['msg']      = 'OK';
				$result['memberID'] = $member['memberID'];
				$result['nickName'] = $member['nickName'];
				$result['email']    = $member['email'];
			} else {
				$result['msg'] = $member['msg'];
			}
		}

		echo json_encode($result);
	}

	function banMember() {
		$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

		Admin::banMember($id);

		echo 'OK';
	}

	function unbanMember() {
		$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

		Admin::unbanMember($id);

		echo 'OK';
	}

	function pointsAdjust() {
		$id     = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		$points = (isset($_REQUEST['points'])) ? $_REQUEST['points'] : 0;

		Admin::pointsAdjust($id, $points);

		echo 'OK';
	}

	function coinAdjust() {
		$id     = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		$coin = (isset($_REQUEST['coin'])) ? $_REQUEST['coin'] : 0;

		Admin::coinAdjust($id, $coin);

		echo 'OK';
	}

}
