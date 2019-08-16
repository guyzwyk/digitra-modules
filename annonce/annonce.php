<?php
	require_once ('library/annonce.inc.php');
	$myAnnonce			       		=   new cwd_annonce();
	$myAnnonce->limit          		=   $_REQUEST['limite']; // For pagination
	
	$pageAnnonce		       		=   $myPage->get_pages_modules_links("annonce", $_SESSION["LANG"]); //$thewu32_modLink[annonce];	
	$pageMaster                		=   $myPage->set_mod_page_master($pageAnnonce); //Vers la page du module annonce dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster        		=   $myPage->get_mod_link($myPage->set_mod_pages($pageAnnonce), $mod_lang_output['ANNONCE_BOX_LINK_ALL']); // Lien vers la page master	
	$link_back_to_pageMaster   		=   "<a href=\"".$pageMaster."\">".$mod_lang_output["ANNONCE_PAGE_BACK"]."</a>";
			
	//:::::::::::::::::::::::::::::::Annonce Module:::::::::::::::::::::::::::::::
	$annonceLast					= 	$myAnnonce->dt_pageBox($mod_lang_output["ANNONCE_BOX_TITLE"], $myAnnonce->load_last_annonce(5, $pageAnnonce, $_SESSION["LANG"]), $link_to_pageMaster, 'fa fa-bullhorn');
	
	if($_REQUEST[level] 			== 'front'){
		//print 'Annonces : '.$link_to_pageMaster.'<br />';
		//$annonce_accordionContent		=	$myAnnonce->load_accordion($myAnnonce->tbl_annonce, $myAnnonce->tbl_annonceCat, $myAnnonce->fld_annonceId, $myAnnonce->fld_annonceTitle, $myAnnonce->fld_annonceCatId, $myAnnonce->fld_annonceCatLib, 5, $pageAnnonce, $_SESSION['LANG']);
		//$annonce_accordion				=	$myAnnonce->dt_pageBox('LES ANNONCES', $annonce_accordionContent, $link_to_pageMaster, 'fa fa-bullhorn');
	}
	elseif($_REQUEST['mod'] 		== 'annonce'){
	    $modSecondaryMenu			= 	$myAnnonce->dt_pageBox($mod_lang_output['ANNONCE_CAT_SIDE_BOX_TITLE'], $myAnnonce->load_annonce_cat($pageAnnonce, $mod_lang_output["ANNONCE_CAT_ERR"], '', $_SESSION['LANG']), '');
	    if($_REQUEST['level'] 		== 	"inner"){
	        $pageHeader				= 	$mod_lang_output["ANNONCE_PAGE_HEADER"]; //strip_tags(stripslashes($annonceTitle));
	        $pageTitle				= 	$mod_lang_output["ANNONCE_PAGE_TITLE"];
	        $pageContent			.= 	stripslashes($myAnnonce->load_annonce($pageAnnonce, 30, '&raquo;&nbsp;'.$mod_lang_output["READ_MORE"], $_SESSION["LANG"]));
	        
	        if(isset($_REQUEST[$myAnnonce->URI_annonce]) && ($_REQUEST['view'] == 'detail')){
	            $tabAnnonces 		= 	$myAnnonce->get_annonce($_REQUEST[$myAnnonce->URI_annonce]);
	            $cat				= 	$myAnnonce->get_annonce_cat_by_id($tabNews['annonceCATID']);
	            $annonceTitle		= 	strip_tags(stripslashes($tabAnnonces['annonceTITLE']));
	            $annonceLib 		= 	$tabAnnonces['annonceLIB'];
	            $annoncePJ			= 	(($tabAnnonces['annoncePJ'] != "") ? ("<p style=\"font-weight:bold;\"><span style=\"text-decoration:underline;\">".$mod_lang_output["ANNONCE_PJ"]." :</span> <a target=\"_blank\" href=\"dox/$tabAnnonces[annoncePJ]\">$tabAnnonces[annoncePJ]</a></p>") : (""));
	            $annonceSignature 	= 	(($tabAnnonces['annonceSIGNATURE'] != "") ? ("<p style=\"font-weight:bold;\">$tabAnnonces[annonceSIGNATURE]</p>") : (""));
	            $annoncePageBck		= 	"<p>$link_back_to_pageMaster</p>";
	            $pageHeader			= 	$mod_lang_output["ANNONCE_PAGE_HEADER"].' - '.strip_tags(stripslashes($annonceTitle));
	            $pageTitle			= 	$mod_lang_output["ANNONCE_PAGE_TITLE"];
	            //Build the content
	            $annonceContent		= 	$annoncePageBck."<h2>$annonceTitle</h2>".$annonceLib.$annoncePJ.$annonceSignature.$annoncePageBck;
	            $pageContent		= 	$annonceContent;
	            $pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $annonceTitle, "", "&raquo;", $_SESSION["LANG"]);
	            $annonceLast		= 	$myAnnonce->dt_pageBox($mod_lang_output["ANNONCE_BOX_TITLE"], $myAnnonce->load_last_annonce(5, $pageAnnonce, $_SESSION["LANG"]), '', 'fa fa-bullhorn');
	        }
	        elseif(isset($_REQUEST[$myAnnonce->URI_annonceCat])){
	            $myAnnonce->limit	= 	$_REQUEST['limite'];
	            $annonceTitle		= 	$mod_lang_output["ANNONCE_PAGE_TITLE"]." :: ".$myAnnonce->get_annonce_cat_by_id($_REQUEST[$myAnnonce->URI_annonceCat]);
	            $annonceContent		= 	$myAnnonce->load_annonce_by_cat($pageAnnonce, $_REQUEST[$myAnnonce->URI_annonceCat], 20, $mod_lang_output["READ_MORE"]);
	            $pageHeader			= 	$mod_lang_output["ANNONCE_PAGE_HEADER"].' - '.strip_tags(stripslashes($annonceTitle));
	            $pageTitle			=	$annonceTitle;
	            $pageContent		= 	stripslashes($annonceContent);
	            $pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $annonceTitle, "", "&raquo;", $_SESSION["LANG"]);
	        }
	    }
	    
		if($_REQUEST['level'] == "inner"){		
			if(isset($_REQUEST[$myAnnonce->URI_annonce]) && ($_REQUEST['view'] == $myPage->uri_page_view[1])){
				$tabAnnonces 		= 	$myAnnonce->get_annonce($_REQUEST[$myAnnonce->URI_annonce]);
				$cat				= 	$myAnnonce->get_annonce_cat_by_id($tabAnnonces['annonceCATID']);
				$annonceTitle		= 	stripslashes($tabAnnonces['annonceTITLE']);
				$annonceLib 		= 	$tabAnnonces['annonceLIB'];
				$annonceDatePub		=	$myAnnonce->date_en2($tabAnnonces['annonceDATEPUB']);
				$annonceDateCrea	=	$myAnnonce->date_en2($tabAnnonces['annonceDATECREA']);
				$annoncePJ			= 	(($tabAnnonces['annoncePJ'] != "") ? ("<p style=\"font-weight:bold;\"><span style=\"text-decoration:underline;\">".$mod_lang_output["ANNONCE_PJ"]." :</span> <a target=\"_blank\" href=\"dox/$tabAnnonces[annoncePJ]\">$tabAnnonces[annoncePJ]</a></p>") : (""));
				$annonceSignature 	= 	(($tabAnnonces['annonceSIGNATURE'] != "") ? ("<p style=\"font-weight:bold;\">$tabAnnonces[annonceSIGNATURE]</p>") : (""));
				//$pageAnnonceBck		= 	"<a href=\"$pageAnnonce".".html"."\">".$mod_lang_output["ANNONCE_PAGE_BACK"]."</a>";
				$pageHeader			= 	$mod_lang_output["ANNONCE_PAGE_HEADER"].' - '.stripslashes($annonceTitle);
				$pageTitle			= 	$mod_lang_output["ANNONCE_PAGE_TITLE"];
				$annonceCatUrl		=	$pageAnnonce.'-cat@'.$tabAnnonces['annonceCATID'].'.html';
				
				$arr_annonceDetail	=	array('ANNONCE_DETAIL_ID'		=>	$_REQUEST[$myAnnonce->URI_annonce],
											  'ANNONCE_DETAIL_TITLE'	=>	$annonceTitle,
											  'ANNONCE_DETAIL_CAT'		=>	$cat,
											  'ANNONCE_DETAIL_DESCR'	=>	$annonceLib,
											  'ANNONCE_DETAIL_PJ'		=>	$annoncePj,
											  'ANNONCE_DETAIL_SIGN'		=>	$annonceSignature,
											  'ANNONCE_DETAIL_DATE_PUB'	=>	$annonceDatePub,
											  'ANNONCE_DETAIL_DATE_CREA'=>	$annonceDateCrea,
											  'ANNONCE_CAT_URL'			=>	$annonceCatUrl,
											  'ANNONCE_PAGE_BACK'		=>	$link_back_to_pageMaster
				);
				
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $annonceTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
			elseif($_REQUEST['view'] == 'cat'){
				$myAnnonce->limit	= 	$_REQUEST['limite'];
				$annonceTitle		= 	$mod_lang_output["ANNONCE_PAGE_TITLE"]." : ".$myAnnonce->get_annonce_cat_by_id($_REQUEST['catId']);
				$annonceContent		= 	$myAnnonce->load_annonce_by_cat($pageAnnonce, $_REQUEST[$myAnnonce->URI_annonceCat], 20, $mod_lang_output["READ_MORE"]);
				$pageHeader			= 	$mod_lang_output["ANNONCE_PAGE_HEADER"].' - '.strip_tags(stripslashes($annonceTitle));
				$pageTitle			=	$annonceTitle;
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $annonceTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
		}
	}

	/*Annonce assignations*/
	$oSmarty->assign('s_annonceSideBoxTitle', $mod_lang_output['ANNONCE_SIDE_BOX_TITLE']);
	$oSmarty->assign('s_annonceCatSideBoxTitle', $mod_lang_output['ANNONCE_CAT_SIDE_BOX_TITLE']);
	$oSmarty->assign('s_pageMaster', $pageMaster);
	$oSmarty->assign('s_link_toPageMaster', $link_to_pageMaster);
	$oSmarty->assign('s_link_back_toPageMaster', $link_back_to_pageMaster);
	$oSmarty->assign('s_annonceLast', stripslashes($annonceLast));
	$oSmarty->assign('s_annoncePageMaster', stripslashes($annonce_pageMaster));
	$oSmarty->assign('s_annonce_accordion', stripslashes($annonce_accordion));