<?php
    
	$myPage				= 	new cwd_page();
	$gallery			= 	new cwd_gallery("../modules/gallery/img/thumbs/", "../modules/gallery/img/main/", "../modules/gallery/spry/data/");
	$pageGallery		= 	$myPage->get_pages_modules_links("gallery");
	$admin_pageTitle	=	"Gestionnaire de Gal&eacute;rie Photo";
	//$gallery->URI_galleryCatVar	= $_REQUEST[$URI_galleryCatVar];
	
	$gallery->build_step_carousel("../modules/gallery/stepcarousel.htm", $pageGallery, 10);
?>
<?php
	require("../modules/gallery/langfiles/".$langFile.".php"); //Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>