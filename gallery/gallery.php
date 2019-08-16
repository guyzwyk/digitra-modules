<?php
	require_once('library/gallery.inc.php');
	$myGallery 			       =   new cwd_gallery("modules/gallery/img/thumbs/", "modules/gallery/img/main/", "modules/gallery/spry/data/");
	$myGalleryDetail	       =   new cwd_gallery("modules/gallery/img/thumbs/", "modules/gallery/img/main/", "modules/gallery/spry/data/");
	
	$pageGallery		       =   $myPage->get_pages_modules_links("gallery", $_SESSION["LANG"]); //$thewu32_modLink[annonce];
	$pageMaster                =   $myPage->set_mod_page_master($pageGallery); //Vers la page du module gallery dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster        =   $myPage->get_mod_link($myPage->set_mod_pages($pageGallery), $mod_lang_output['GALLERY_BOX_LINK_ALL']); // Lien vers la page master
	$link_back_to_pageMaster   =   "<a href=\"".$pageMaster."\">".$mod_lang_output["GALLERY_PAGE_BACK"]."</a>";
	//Count available albums
	$total_gallery             =   $myGallery->count_in_tbl_where1_lang($myGallery->tbl_galleryCat, $myGallery->fld_galleryCatId, 'display', '1');
	
	//:::::::::::::::::::::::::::::::Gallery Module:::::::::::::::::::::::::::::::
	$galleryLast		       =   $myGallery->dt_pageBox($mod_lang_output["GALLERY_BOX_TITLE"], $myGallery->load_last_gallery(5, $pageGallery, $_SESSION["LANG"]), $link_to_pageMaster, 'fa fa-image');
	
	
	$pageGallerys		       =   "<a title=\"".$mod_lang_output['GALLERY_BOX_LINK_ALL']."\" href=\"".$pageGallery.'-all'.$thewu32_appExt."\">".$mod_lang_output['GALLERY_BOX_LINK_ALL']."</a>";
	$spryInit			       =   $myGallery->init_spry_gallery();
	
	$arr_galleryAll		       =   $myGallery->arr_load_last_thumb_by_cat($pageGallery);
	$arr_galleryCat		       =   $myGallery->arr_load_gallery_cat($pageGallery, $pageLang);
	
	
	//Photo aleatoire
	//$gallery_random		      =    stripslashes($myGallery->load_random_gallery($pageGallery, $mod_lang_output["GALLERY_RND_BOX-TITLE"], 'gallery_random'));
	
	//Featured gallery widget
	$arr_randomPix		       	=	$myGallery->arr_load_random_gallery($pageGallery);
	$gallery_randomContent    	=   "<div class=\"gallery_random\"><a title=\"".$arr_randomPix['PIX_DESCR']."\" href=\"".$arr_randomPix['PIX_ALBUM_URL']."\"><img src=\"".$myGallery->imgs_dir.$arr_randomPix['PIX_NAME']."\" /><p>".$arr_randomPix['PIX_ALBUM_TITLE']."</p></a></div>";
	
	//Photo aleatoire dans un box
	//$gallery_rndBox			= 	$myGallery->dt_secondaryBoxed($mod_lang_output["GALLERY_RND_BOX-TITLE"], $gallery_random, $pageGallerys, 'tp tp-pictures', 'featured-gallery-widget');
	$gallery_random				=   $myGallery->dt_pageBox($mod_lang_output["GALLERY_RND_BOX-TITLE"], $gallery_randomContent, $link_to_pageMaster, 'fa fa-image');
	
	
	//Step Carousel plugin
	$load_carouselImg		=	$myGallery->build_step_carousel('', $pageGallery);
		$stepCarousel		= 	"<h4>".$mod_lang_output["GALLERY_BOX_TITLE"]."</h4>
								<div id=\"homeGallery\" class=\"stepcarousel\">
									<div class=\"belt\">
										".$load_carouselImg."
									</div>
								</div> <!--
								<p id=\"homeGallery-paginate\" style=\"text-align:center\">
									<img style=\"border:none;\" src=\"plugins/stepcarousel/img/opencircle.png\" data-over=\"plugins/stepcarousel/img/graycircle.png\" data-select=\"plugins/stepcarousel/img/closedcircle.png\" data-moveby=\"1\" />
								</p> -->";
	
	//:::::::::::::::::::::::::::::::Gallery Module:::::::::::::::::::::::::::::::
	
	//Gallery Module Linkage
	$btn_gallerySlide	= "<a href='#' onclick=\"window.open('modules/gallery/gallery_slide.html', '', 'directories=no, toolbar=no, scrollbars=1, resizable=0, width=800, height=700')\"><img src=\"modules/gallery/img/btn_diapo.jpg\" /></a>";
	
	
	if($_REQUEST[level] == 'front'){
		//$galleryLast	= 	$myGallery->load_recent_gallery_home(3, $pageGallery, $_SESSION["LANG"]);
	}
	elseif($_REQUEST['mod'] 	      == 'gallery'){
		if($_REQUEST['level']         == "inner"){
			//$modSecondaryMenu		  = 	$myGallery->cwdBoxed($mod_lang_output['GALLERY_CAT_SIDE_BOX_TITLE'], $myGallery->load_gallery_cat($pageGallery, $mod_lang_output["GALLERY_CAT_ERR"], '', $pageLang), '');
		    $modSecondaryMenu         =   $myGallery->dt_pageBox($mod_lang_output["GALLERY_BOX_TITLE"], $myGallery->load_last_gallery(10, $pageGallery, $_SESSION["LANG"]), '');
		    $pageContent              =   stripslashes($myGallery->load_last_thumb_by_cat($pageGallery, "gallery_recent", $total_gallery, 6, 40));
			if(isset($_REQUEST[$myGallery->URI_gallery]) && ($_REQUEST[view] == 'detail')){
				$tabGallerys 		  =     $myGallery->get_gallery($_REQUEST[$myGallery->URI_gallery]);
				$cat				  = 	$myGallery->get_gallery_cat_by_id($tabGallerys[galleryCATID]);
				$galleryTitle		  = 	stripslashes($tabGallerys[galleryTITLE]);
				$galleryLib 		  = 	$tabGallerys[galleryLIB];
				$galleryDatePub		  =	    $myGallery->date_en2($tabGallerys[galleryDATEPUB]);
				$galleryDateCrea	  =	    $myGallery->date_en2($tabGallerys[galleryDATECREA]);
				$galleryPJ			  = 	(($tabGallerys[galleryPJ] != "") ? ("<p style=\"font-weight:bold;\"><span style=\"text-decoration:underline;\">".$mod_lang_output["GALLERY_PJ"]." :</span> <a target=\"_blank\" href=\"dox/$tabGallerys[galleryPJ]\">$tabGallerys[galleryPJ]</a></p>") : (""));
				$gallerySignature 	  = 	(($tabGallerys[gallerySIGNATURE] != "") ? ("<p style=\"font-weight:bold;\">$tabGallerys[gallerySIGNATURE]</p>") : (""));
				$pageGalleryBck		  = 	"<p><a href=\"$pageGallery".".html"."\">".$mod_lang_output["GALLERY_PAGE_BACK"]."</a></p>";
				$pageHeader			    = 	$mod_lang_output["GALLERY_PAGE_HEADER"].' - '.stripslashes($galleryTitle);
				$pageTitle			    = 	$mod_lang_output["GALLERY_PAGE_TITLE"];
				$galleryCatUrl		    =	$pageGallery.'-cat@'.$tabGallerys[galleryCATID].'.html';
	
				 $arr_galleryDetail	    =	array('GALLERY_DETAIL_ID'		=>	$_REQUEST[$myGallery->URI_gallery],
						'GALLERY_DETAIL_TITLE'		=>	$galleryTitle,
						'GALLERY_DETAIL_CAT'		=>	$cat,
						'GALLERY_DETAIL_DESCR'		=>	$galleryLib,
						'GALLERY_DETAIL_PJ'			=>	$galleryPj,
						'GALLERY_DETAIL_SIGN'		=>	$gallerySignature,
						'GALLERY_DETAIL_DATE_PUB'	=>	$galleryDatePub,
						'GALLERY_DETAIL_DATE_CREA'	=>	$galleryDateCrea,
						'GALLERY_CAT_URL'			=>	$galleryCatUrl
				); 
	
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $galleryTitle, "", "&raquo;", $_SESSION['LANG']);
			}
			elseif($_REQUEST['view'] == 'cat'){
			    //Get all the gallery_cat_id in an array when the gcId var is defined!
			    $tab_galleryCat	= $myGallery->get_gallery_cat_id();
			    if(in_array($_REQUEST[$myGallery->URI_galleryCatVar], $tab_galleryCat)){
			        $gallery_thumbs 	= stripslashes($myGallery->load_thumbs($pageGallery, $_REQUEST[$myGallery->URI_galleryCatVar], 6, "gallery_thumbs", '', 'roadtrip'));
			        $gallery_cat_title	= $myGallery->get_gallery_cat_lib_by_id($_REQUEST[$myGallery->URI_galleryCatVar]);
			        $gallery_cat_descr	= $myGallery->get_gallery_cat_by_id("gallery_cat_descr", $_REQUEST[$myGallery->URI_galleryCatVar]);
			        $galleryNavBack		= "<p><a href=\"".$pageGallery.".html\">".$mod_lang_output["GALLERY_ALBUM_BACK"]."</a></p>";
			        $modSecondaryMenu   =   $myGallery->dt_pageBox($mod_lang_output["GALLERY_BOX_TITLE"], $myGallery->load_last_gallery(10, $pageGallery, $_SESSION["LANG"]), $link_to_pageMaster);
			        
			    }
			    /* else{
			        $gallery_detail_link	= $pageGallery;
			        $gallery_thumbs 		= $myGallery->load_thumbs($pageGallery, 1, 5, "gallery_thumbs");
			        $gallery_cat_title		= $myGallery->get_gallery_cat_lib_by_id(1);
			        $gallery_cat_descr		= $myGallery->get_gallery_cat_by_id("gallery_cat_descr", 1);
			    } */
			    $pageHeader			= 	$mod_lang_output["GALLERY_PAGE_TITLE"]." :: ".$gallery_cat_title;
			    $pageTitle			=	$gallery_cat_title;
			    $pageDescr			= 	$gallery_cat_descr;
			    $pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $gallery_cat_title, "", "&raquo;", $_SESSION["LANG"]);
			    $pageContent		= 	"<p style=\"font-weight:bold; text-decoration:underline;\">&raquo; $link_back_to_pageMaster</p>"."<div class=\"gallery_page_descr\">$pageDescr</div>".$gallery_thumbs."<p style=\"font-weight:bold; text-decoration:underline;\">&raquo; $link_back_to_pageMaster</p>";
			    
			}
		}
	}

	
	//Gallery assignations
	
	$oSmarty->assign('s_gallery_pageMaster', stripslashes($link_to_pageMaster));
	$oSmarty->assign('s_arr_randomPix', $arr_randomPix); //Featured gallery
	$oSmarty->assign('s_arr_galleryCat', $arr_galleryCat);
	$oSmarty->assign('s_arr_galleryCats', $arr_galleryCats);
	$oSmarty->assign('s_arr_galleryAll', $arr_galleryAll);
	$oSmarty->assign('s_gallery_catDate', $gallery_catDate);
	
	$oSmarty->assign('s_galleryLast', $galleryLast);
		
	$oSmarty->assign('s_gallery_cat_box', stripslashes(utf8_decode($gallery_cat_box)));
	$oSmarty->assign('s_gallery_cat_title', stripslashes(utf8_decode($gallery_cat_title)));
	$oSmarty->assign('s_gallery_cat_descr', stripslashes(utf8_decode(utf8_decode($gallery_cat_descr))));
	$oSmarty->assign('s_gallery_thumbs', stripslashes(utf8_decode($gallery_thumbs)));
	$oSmarty->assign('s_gallery_random', stripslashes($gallery_random));
	$oSmarty->assign('s_gallery_rnd_box', stripslashes(utf8_decode($gallery_rndBox)));
	$oSmarty->assign('s_gallery_recents', stripslashes(utf8_decode($gallery_recents)));
	$oSmarty->assign('s_gallery_all', stripslashes(utf8_decode($gallery_all))); //In the gallery root (gallery.php)
	$oSmarty->assign('s_gallery_header', $galleryHeader);
	$oSmarty->assign('s_gallery_navback', $galleryNavBack);
	$oSmarty->assign('s_gallery_btn', $galleryBtn);
	$oSmarty->assign('s_gallery_slide_btn', $btn_gallerySlide);
	
	//Spry Initialisation
	$oSmarty->assign('s_spry_gallery_init', $spryInit);
	
	//Step Carousel assignations
	$oSmarty->assign('s_step_carousel', $stepCarousel);
	
	//Gallery Detail Assignation
	$oSmarty->assign('s_gallery_detail_thumbs', $myGalleryDetail->cwdBoxed(utf8_decode($gallery_cat_title), stripslashes(utf8_decode($galleryDetailThumbs)), ""));