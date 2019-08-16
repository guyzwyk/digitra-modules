<?php
	require_once ('./modules/gallery/library/gallery.inc.php');
	require_once ('library/catalog.inc.php');
	$myCatalog			= new cwd_catalog();
	$catalogPage		= $myPage->get_pages_modules_links("catalog");
	$catalogsPage		= "&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['CATALOG_BOX_LINK_ALL']."\" href=\"".$catalogPage.".html\">".$lang_output['CATALOG_BOX_LINK_ALL']."</a>";
	$catalogLast		= $myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_TITLE"], $myCatalog->load_recent_product(5, $catalogPage), $catalogsPage);
	
	
	//:::::::::::::::::::::::::::::::Catalog Module:::::::::::::::::::::::::::::::
	
	if($_REQUEST[level] == 'front'){
			$catalogsPage	= "&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['CATALOG_BOX_LINK_ALL']."\" href=\"".$catalogPage.".html\">".$lang_output['CATALOG_BOX_LINK_ALL']."</a>";
			$catalogLast	= $myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_TITLE"], $myCatalog->load_recent_product(5, $catalogPage), $catalogsPage);
	}
	elseif($_REQUEST[mod] 	== 'catalog'){
		//$modSecondaryMenu	= $myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_CAT_TITLE"], $myCatalog->load_catalog_cat($catalogPage, $lang_output["CATALOG_CAT_ERR"]), '');
		if($_REQUEST[level] == "inner"){
			$catalogsPage			= "&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['CATALOG_BOX_LINK_ALL']."\" href=\"".$catalogPage.".html\">".$lang_output['CATALOG_BOX_LINK_ALL']."</a>";
			//print_r (pathinfo($catalogPage));
			$myCatalog->limit		= 	$_REQUEST[limite];
			$pageTitle				= 	$lang_output["CATALOG_PAGE_TITLE"];
			$pageContent			.= 	stripslashes($myCatalog->load_catalog($catalogPage, $pageLang, 6, '&raquo;&nbsp;'.$lang_output["READ_MORE"]));
			$pageHeader				= 	$lang_output["CATALOG_PAGE_HEADER"]; //strip_tags(stripslashes($catalogLib));
			$pageSecondaryMenu		= 	$myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_CAT_TITLE"], $myCatalog->load_product_cat($catalogPage, $lang_output["CATALOG_CAT_ERR"]), '', "box_right");
			$catalogLast			= 	$myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_TITLE"], $myCatalog->load_recent_product(5, $catalogPage), '');
			
			if(isset($_REQUEST[$myCatalog->URI_product]) && ($_REQUEST[view] == 'detail')){
				$tabProducts 		= 	$myCatalog->get_product($_REQUEST[$myCatalog->URI_product]);
				$productCat			= 	$myCatalog->get_product_cat_by_id($myCatalog->fld_catalogTypeLib, $tabProducts[product_CATID]);
				$productLib			= 	stripslashes($tabProducts[product_LIB]);
				$productPV			= 	$tabProducts[product_PVENTE];
				$product_cmdBtn		=	"<a href=\"#\">$lang_output[CATALOG_CMD_BTN]</a>";
				$product_addKartBtn	=	"<a href=\"#\">$lang_output[CATALOG_ADD_KART_BTN]</a>";
				$productDevise		=	$lang_output["CATALOG_DEVISE"];
				$productDescr 		= 	stripslashes(nl2br($tabProducts[product_DESCR]));
				$catalogPageBck		= 	"<p><a href=\"$catalogPage".".html"."\">".$lang_output["CATALOG_PAGE_BACK"]."</a></p>";
				$pageHeader			= 	$lang_output["CATALOG_PAGE_HEADER"].' - '.strip_tags(stripslashes($productLib));
				$pageTitle			= 	$productLib;
				$pageTags			= 	$tabProducts[product_TAGS];
				
				$productImg			= 	(($tabProducts[product_IMG] == "") ? ($myCatalog->defaultImg) : ($tabProducts[product_IMG]));
				$productImg			= 	"<img src=\"".$myCatalog->imgs_dir.$productImg."\" />";
				
				//Build the content
				$catalogContent		= 	"$catalogPageBck
										<div class=\"catalog_detail\">
											<div class=\"catalog_detail_title\"><span class=\"catalog_type\">$productCat :</span> $productLib</div>
											<div class=\"catalog_detail_body\">
												<div class=\"catalog_detail_img\">$productImg</div>
												<div class=\"catalog_detail_descr\">$productDescr</div>
												<div style=\"clear:both;\"></div>
											</div>
											<div class=\"product_detail_sub\">
												<ul>
													<li>$productPV $productDevise</li>
													<!-- <li>$product_cmdBtn</li> -->
													<li style=\"border-right:0;\">$product_addKartBtn</li>
												</ul>
											</div>
											<div style=\"clear:both;\"></div>
										</div>
										<div style=\"clear:both;\"></div>
										$catalogPageBck
										<div style=\"clear:both;\"></div>";
										
				$pageContent		= 	$catalogContent;
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $productLib, "", "&raquo;");
				$catalogLast		= 	$myCatalog->cwdBoxed($lang_output["CATALOG_RBOX_TITLE"], $myCatalog->load_recent_product(5, $catalogPage), $catalogsPage);
			}
			elseif(isset($_REQUEST[$myCatalog->URI_productCat])){
				$myCatalog->limit	= 	$_REQUEST[limite];
				$catalogLib			= 	$myCatalog->get_product_cat_by_id($myCatalog->fld_catalogTypeLib, $_REQUEST[$myCatalog->URI_productCat]);
				$catalogContent		= 	$myCatalog->load_product_by_cat($catalogPage, $_REQUEST[$myCatalog->URI_productCat], 20, $lang_output["READ_MORE"]);
				$pageHeader			= 	$lang_output["CATALOG_PAGE_HEADER"].' - '.strip_tags(stripslashes($catalogLib));
				$pageTitle			=	$lang_output["CATALOG_PAGE_TITLE"]." : ".$catalogLib;
				$pageContent		= 	stripslashes($catalogContent);
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $catalogLib, "", "&raquo;");
			}
		}
	}
	
	
	
	/*Catalog assignations*/
	$oSmarty->assign('s_catalogLast', stripslashes(utf8_decode($catalogLast)));