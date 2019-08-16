<?php
	require_once('library/banner.inc.php');

	$myBanner = new cwd_banner();
	
	//:::::::::::::::::::::::::::::::Banner Module:::::::::::::::::::::::::::::::
	/** Do not modify here **/
	$top_ban			= 	$myBanner->get_page_ban($_REQUEST[pId], 1, "banTop");
	$left_ban			= 	$myBanner->get_page_ban($_REQUEST[pId], 2, "banLeft");
	$right_ban			= 	$myBanner->get_page_ban($_REQUEST[pId], 3, "banRight");
	$bottom_ban			= 	$myBanner->get_page_ban($_REQUEST[pId], 4, "banBottom");
	$inside_ban			= 	$myBanner->get_page_ban($_REQUEST[pId], 5, "banInside");
	
	if($_REQUEST[level] == "front"){
		//To be displayed only at the homepage
		$home_ban			=	$myBanner->get_home_ban($_REQUEST[pId]);
	}
	/*****************************************************************/
	
	//$topBanner		= 	$myBanner->get_page_banner($_SESSION[LANG]);
	$topBanLangDir		= 	$topBanner["LANG"];
	$topBanFile			= 	$topBanner["FILE"];
	
	//**Banners smarty assignations
	$oSmarty->assign('s_bannerTop', $top_ban);
	$oSmarty->assign('s_bannerLeft', $left_ban);
	$oSmarty->assign('s_bannerRight', $right_ban);
	$oSmarty->assign('s_bannerBottom', $bottom_ban);
	$oSmarty->assign('s_bannerInside', $inside_ban);
	$oSmarty->assign('s_bannerHome', $home_ban);
	
	$oSmarty->assign('s_topBanLangDir', $topBanLangDir);
	$oSmarty->assign('s_topBanFile', $topBanFile);
?>