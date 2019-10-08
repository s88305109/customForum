<?php
require(dirname(__FILE__).'/core/init.php');

class c_index
{    
	function __construct() {
		Member::officialWebsiteLogin();
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
		include('views/index/index.php');
		include('views/common/foot.php');
	}

}
