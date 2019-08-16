<?php //
	require('library/file.inc.php');
	$myFile 						= 	new cwd_file();
	$myFileDetail   				=   new cwd_file();
	$myFile->limit 					=   $_REQUEST['limite'];
	
	$pageFile		       			=   $myPage->get_pages_modules_links("file", $_SESSION["LANG"]); //$thewu32_modLink[file];
	$pageMaster            			=   $myPage->set_mod_page_master($pageFile); //Vers la page du module filee dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster    			=   $myPage->get_mod_link($myPage->set_mod_pages($pageFile), $mod_lang_output['FILE_BOX_LINK_ALL']); // Lien vers la page master
	
	$link_back_to_pageMaster   		=   "<a href=\"".$pageMaster."\">".$mod_lang_output["FILE_PAGE_BACK"]."</a>";
	
	//:::::::::::::::::::::::::::::::File Module:::::::::::::::::::::::::::::::	
	$fileLast		    			= 	$myFile->cwdBoxed($mod_lang_output["FILE_BOX_TITLE"], $myFile->load_last_file($pageFile, 5, $_SESSION['LANG']), $link_to_pageMaster, 'fa fa-file');
	$fileCount		    			=	$myFile->count_files_valid();
	$file_catCount	    			=	$myFile->count_files_by_cat($_REQUEST[$myFile->URI_fileCatVar]);
	$pageFileBck	    			= 	"<p><a href=\"".$myFile->mod_pageMaster."\">".$mod_lang_output["FILE_PAGE_BACK"]."</a></p>";
	//$fileBoxLink	    			= 	"<a class=\"lnk_gray\" href=\"$pageFile".$thewu32_appExt."\">".$mod_lang_output["FILE_BOX_LINK"]."</a>";

?>
<?php
if(($_REQUEST['level'] 				== "front") && (!isset($_SESSION['CONNECTED']))){
	//Show accordion at homepage
	$accordion 						= 	$myFile->dt_pageBox($mod_lang_output['FILE_HOME_BOX_ACCORDION'], $myFile->load_file_accordion($pageFile, 5, $_SESSION['LANG']), $link_to_pageMaster, 'fa fa-file');
} 
elseif($_REQUEST['mod'] 			== 'file'){
    $modSecondaryMenu				= 	$myFile->dt_pageBox($mod_lang_output['FILE_CAT_SIDE_BOX_TITLE'], $myFile->load_file_cat($pageFile, $mod_lang_output["FILE_CAT_ERR"], '', $_SESSION['LANG']), '');
    $fileLast		    			= 	$myFile->dt_pageBox($mod_lang_output["FILE_BOX_TITLE"], $myFile->load_last_file($pageFile, 5, $_SESSION['LANG']), '', 'fa fa-file');
	if($_REQUEST['level'] 			== "inner"){
	    $pageContent				.= 	stripslashes($myFile->load_file($pageFile, 100, '&raquo;&nbsp;'.$mod_lang_output["READ_MORE"], $_SESSION["LANG"]));
		if(isset($_REQUEST[$myFile->URI_file]) && ($_REQUEST['view'] == 'detail')){
			$tabFile 				= 	$myFile->get_file($_REQUEST[$myFile->URI_file]);
			$cat					= 	$myFile->get_file_cat_by_id($tabFiles['fileCATID']);
			$fileInfo				= 	$myFile->get_file_ext_name($tabFile['fileURL']);
			$fileUrl				= 	$myFile->modDir."dox/files/".$tabFile['fileURL'];
			$fileSize				= 	@ceil((filesize($fileUrl) / 1024));
			//$fileType				= 	$myFile->get_file_ext($fileUrl);
			$fileType				=	$fileInfo['type'];
			$fileIcon				=	$fileInfo['img'];
			$fileTitle				= 	stripslashes($tabFile['fileTITLE']);
				
			//Build the content
			$fileContent 			= 	"<h2>".$mod_lang_output["FILE_LBL_DETAIL_DESCR"]." : <span style=\"font-weight:bold; color:#000; text-decoration:none; font-size:12px;\">$tabFile[fileTITLE]</span></h2>
										<div style=\"background: url(".$myFile->modDir."/img/icons/".$fileInfo['img'].") left top no-repeat; padding-left:40px;\">
											<p style=\"font-style:italic;\">$tabFile[fileDESCR]</p>
											<p><strong>".$mod_lang_output["FILE_LBL_TYPE"]." :</strong> $fileInfo[type]</p>
											<p><strong>".$mod_lang_output["FILE_LBL_SIZE"]." :</strong> $fileSize Ko</p>
											<p><a style=\"background: url(".$myFile->modDir."/img/icons/downloadIcon_23.png) left center no-repeat; padding:25px;\" href=\"$fileUrl\">&raquo;".$mod_lang_output["FILE_LBL_DLD"]."</a></p>
										</div>";
			
			$pageHeader				.=	' :: '.$fileTitle;
			$pageContent			= 	$filePageBck.stripslashes($fileContent).$filePageBck;
			if($_REQUEST['action'] 	== "dld"){			    
			}

			$pagePathWay			= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $fileTitle, "", "&raquo;", $_SESSION["LANG"]);
		}
		elseif(isset($_REQUEST[$myFile->URI_fileCat])){
			$file_catTitle			=	$myFile->get_file_cat_by_id($_REQUEST[$myFile->URI_fileCat]);
				
			$pagePathWay			= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $fileTitle, "", "&raquo;", $_SESSION["LANG"]);
			$pageHeader				=	$mod_lang_output["FILE_PAGE_CAT_HEADER"]." - ".$file_catTitle;
			$pageTitle				.= 	" - ".$file_catTitle;
			$pageContent			= 	$myFile->load_file_by_cat($pageFile, $_REQUEST[$myFile->URI_fileCat], 50, $mod_lang_output["LABEL_READ_MORE"], $_SESSION['LANG']);
		}
	}
}

		
//Assignations
$oSmarty->assign('s_file_pageMaster', stripslashes($link_to_pageMaster));
$oSmarty->assign('s_fileLast', stripslashes($fileLast));
$oSmarty->assign('s_file_pageBck', $pageFileBck);
$oSmarty->assign('s_file_accordion', $accordion);