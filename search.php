<?php
require(dirname(__FILE__).'/core/init.php');

class c_search
{
	function __construct() {
		Member::officialWebsiteLogin();
		Member::memberVerification();
    }
    
	function search() {
		$searchstr = (isset($_REQUEST['searchstr'])) ? urldecode($_REQUEST['searchstr']) : '';
		$page      = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$topics    = Search::getSearchTopics($searchstr, $page);
		
		include('views/common/head.php');
		include('views/search/search.php');
		include('views/common/foot.php');
	}

}
