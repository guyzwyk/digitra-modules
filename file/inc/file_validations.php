<?php
	//Ajouter un fichier
	$btn_file_insert	= 	$_POST[btn_file_insert];
	$file_selCat		= 	$_POST[file_selCat];
	$file_selLang		=	$_POST['file_hdLang'];
	$txt_file_title 	= 	addslashes($_POST[txt_file_title]);
	$ta_file_descr		= 	addslashes($_POST[ta_file_descr]);
	$datePub			= 	$file->get_datetime();
	
	
	//Les fichiers
	$fileUrl_name = $_FILES[fileUrl]['name'];
	$fileUrl_size = $_FILES[fileUrl]['size'];
	
	
	//Extensions acceptees
	$tabExt = array('gif', 'jpg', 'png', 'pdf', 'docx', 'rtf', 'doc', 'odt', 'zip', 'rar', 'jpeg', 'xls', 'xlsx');
	
	//Rpertoire de destination des CV
	//$uploaddir = "../dox/files/"; = $this->fileDirectory();
	
	
	//Validations *****************************************************************************
	if(isset($btn_file_insert)){
		//$file_img='no_file_img';
	    if($file_selLang == 'NULL' OR $file_selLang == '')
	        $file_insert_err_msg    = $mod_lang_output['FORM_ERROR_LANG'];
		if(empty($txt_file_title) || empty($ta_file_descr))
			$file_insert_err_msg 	= 	$mod_lang_output['FILE_MANDATORY_ERROR'];
		elseif($file->chk_entry($file->tblFile, "file_title", $txt_file_title))
			$file_insert_err_msg 	= 	$mod_lang_output['FILE_EXISTS_ERROR'];
		elseif($file->chk_entry($file->tblFile, "file_descr", $ta_file_descr))
			$file_insert_err_msg 	= 	$mod_lang_output['FILE_DESCR_EXISTS_ERROR'];
		elseif($fileUrl_name == "")
			$file_insert_err_msg 	= $mod_lang_output['FILE_EMPTY_ERROR'];
		elseif(!in_array($file->get_file_ext($fileUrl_name), $tabExt))
			$file_insert_err_msg	=	$mod_lang_output['FILE_EXT_ERROR'];
		else{
			if($insertId = $file->set_file($file_selCat, $_SESSION['uId'], $txt_file_title,  $ta_file_descr, 'NO_FILE', $datePub, $file_selLang)){			
        		//print $fileUrl_name.'<br />Cat is : '.$file_selCat;
                /*** Envoyer le fichier physique et Mettre la table à jour ***/
        		// 1 -Renommage du fichier avec le code categorie et le numero d'insertion ds la table (<catID>_<insertId>.<EXT>)
        		$fileExt 		= $file->get_file_ext($fileUrl_name);
        		$fileUrl_name 	= $file_selCat.'_'.$insertId.'.'.$fileExt;
        				
        		// 2 - Upload proprement dit et mise à jour ds la table des fichiers
        		if(move_uploaded_file($_FILES[fileUrl]['tmp_name'], $file->get_fileDirectory() . $fileUrl_name) && ($file->file_element_update("file_url", $fileUrl_name, $insertId))){
        			$file_insert_cfrm_msg = $mod_lang_output['FILE_INSERT_SUCCESS'];
        			$system->set_log('FILE CREATED - ('.$txt_file_title.')');
        		}
			}
		}
	}
?>

<?php
	//Modifier un fichier
	$btn_file_upd			= 	$_POST[btn_file_upd];
	$hd_file_id				= 	$_POST[hd_file_id];
	$file_selCatUpd			= 	$_POST[file_selCatUpd];
	$file_selLangUpd		=	strtoupper($_POST[file_selLangUpd]);
	$txt_file_title_upd 	= 	addslashes($_POST[txt_file_title_upd]);
	
	$ta_file_descr_upd		= 	addslashes($_POST[ta_file_descr_upd]);
	//$datePubUpd			= $_POST[cmbYearUpd]."-".$_POST[cmbMonthUpd]."-".$_POST[cmbDayUpd];
	
	$file_url				= 	$_POST[hd_file_url]; //Nom du fichier ds la bdd
	$file_display			= 	$_POST[hd_file_display]; //Etat de la publication pendant la modif
	
	$fileUrlUpd_name		= 	$_FILES[fileUrlUpd]['name']; //Nouveau fichier
	$fileUrlUpd_size		= 	$_FILES[fileUrlUpd]['size']; //Taille du nouveau fichier
	
	if(isset($btn_file_upd)){
		if(empty($txt_file_title_upd) || empty($ta_file_descr_upd))
			$file_update_err_msg 	= 	$mod_lang_output['FILE_MANDATORY_ERROR'];
		elseif($fileUrlUpd_name == ''){
			//Si on n'a pas modifie le fichier :
			if($file->update_file($file_selCatUpd, $_SESSION['uId'], $txt_file_title_upd, $ta_file_descr_upd, $file_url, $file_display, $hd_file_id, $file_selLangUpd)){
				$file_update_cfrm_msg 	= $mod_lang_output['FILE_UPDATE_SUCCESS'];
				$system->set_log('FILE UPDATED - ('.$fileUrlUpd_name.')');
			}
		}
		//Si on a modifi� le fichier physique:
		elseif($fileUrlUpd_name	!= ''){
			if(!in_array($file->get_file_ext($fileUrlUpd_name), $tabExt))
				$file_update_err_msg	=	$mod_lang_output['FILE_EXT_ERROR'];
			else{
				//$file_update_cfrm_msg 	= "01 file loaded!";
				//suppression de l'ancien fichier
				$old_file	= $file->get_fileDirectory().$file_url;
				unlink($old_file);
					
				//Renommage, puis upload du nouveau fichier
				$file_ext	= $file->get_file_ext($fileUrlUpd_name);
				$file_url	= $file_selCatUpd."_".$hd_file_id.".".$file_ext;
				if(move_uploaded_file($_FILES[fileUrlUpd]['tmp_name'], $file->get_fileDirectory() . $file_url) 
					&& 
					($file->update_file($file_selCatUpd, $_SESSION['uId'], $txt_file_title_upd, $ta_file_descr_upd, $file_url, $file_display, $hd_file_id, $file_selLangUpd))
					&& 
					($file->file_element_update("file_url", $file_url, $hd_file_id))){
					$file_update_cfrm_msg .= $mod_lang_output['FILE_REPLACE_UPDATE_SUCCESS'];
					$system->set_log('FILE CREATED - ('.$file_url.')');
				}
			}
		}
	}
?>

<?php
	//Ajouter une cat&eacute;gorie de fichier
	$btn_cat_insert	= $_POST[btn_cat_insert];
	$txt_cat_id		= $_POST[txt_cat_id];
	$txt_cat_lib 	= addslashes($_POST[txt_cat_lib]);
	$ta_cat_descr	= addslashes(nl2br($_POST[ta_cat_descr]));
	$selLang        = $_POST['selLang'];
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_id))
			$rub_insert_err_msg		= $mod_lang_output['FILE_CAT_CODE_MANDATORY_ERROR'];
		elseif(empty($txt_cat_lib))
			$rub_insert_err_msg 	= $mod_lang_output['FILE_CAT_EMPTY_ERROR'];
		elseif($file->chk_entry($file->tblFileCat, $file->fld_fileCatId, $txt_cat_id))
			$rub_insert_err_msg 	= $mod_lang_output['FILE_CAT_CODE_EXISTS_ERROR'];
		elseif($file->chk_entry($file->tblFileCat, "file_cat_lib", $txt_cat_lib))
			$rub_insert_err_msg 	= $mod_lang_output['FILE_CAT_EXISTS_ERROR'];
		elseif($file->set_file_cat($txt_cat_id, $txt_cat_lib, $ta_cat_descr, $selLang)){
			$rub_insert_cfrm_msg 	= $mod_lang_output['FILE_CAT_INSERT_SUCCESS'];
			$file->set_log('FILE CATEGORY CREATED - ('.$txt_cat_lib.')');
		}
	}
?>

<?php
	//Modifier une cat&eacute;gorie de fichier
	$hd_cat_id			= $_POST[hd_cat_id];
	$btn_cat_upd		= $_POST[btn_cat_upd];
	$ta_cat_descr_upd	= addslashes($_POST[ta_cat_descr_upd]);
	$txt_cat_lib_upd 	= addslashes(nl2br($_POST[txt_cat_lib_upd]));
	
	if(isset($btn_cat_upd)){
		if(!isset($hd_cat_id))
			$rub_update_err_msg = $mod_lang_output['FILE_CAT_CODE_UPDATE_ERROR'];
		elseif(empty($txt_cat_lib_upd))
			$rub_update_err_msg = $mod_lang_output['FILE_CAT_EMPTY_ERROR'];
		elseif($file->update_file_cat($txt_cat_lib_upd, $ta_cat_descr_upd, $hd_cat_id)){
			$rub_update_cfrm_msg 	= $mod_lang_output['FILE_CAT_INSERT_SUCCESS'];
			$system->set_log('FILE CATEGORY UPDATED - ('.$txt_cat_lib_upd.')');
		}
	}
?>



<?php
	//Actions sur les fichiers et leurs categories
	$what 		= $_REQUEST[what];
	$action		= $_REQUEST[action];
	$fileId		= $_REQUEST[pmId];
	$fileCatId	= $_REQUEST[catId];
	
	switch($action){
		case "fileDelete" : $system->set_log('FILE DELETED -('.$file->get_file_by_id($file->fld_fileTitle, $fileId).')');
							$toDo 	= $file->delete_file($fileId); $file_display_cfrm_msg	=	$mod_lang_output['FILE_DELETE_SUCCESS'];
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "filePrivate": $toDo	= $file->set_file_state($fileId, "0");
							$file_display_cfrm_msg	=	$mod_lang_output['FILE_HIDDEN_SUCCESS']; $system->set_log('FILE SET INVISIBLE');
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "filePublish":	$toDo					= $file->set_file_state($fileId, "1");
							$file_display_cfrm_msg	= $mod_lang_output['FILE_VISIBLE_SUCCESS'];	$system->set_log('FILE SET VISIBLE');
							//Cr&eacute;er le Data Set Correspondant
							//$file->create_xml_annonces("../xml/province_annonce.xml");
		break;
		case "fileUpdate" : $tabUpd			= $file->get_file($fileId);
							$file_displayUpd = true;
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "fileCatDelete" : $system->set_log('FILE CATEGORY DELETED -('.$file->get_file_cat_by_id($fileCatId).')');
							   $toDo					= $file->delete_file_cat($fileCatId);
							   $rub_display_cfrm_msg	= $mod_lang_output['FILE_CAT_DELETE_SUCCESS'];
							  
		break;
		case "fileCatUpdate" : $tabCatUpd 				= $file->get_file_cat($fileCatId);
							   $rub_displayUpd			= true;
		break;
		case "fileCatPublish" : $toDo 					= $file->set_annoncecat_state($ncId, 1);
								$rub_display_cfrm_msg	= $mod_lang_output['FILE_CAT_VISIBLE_SUCCESS'];  $system->set_log('FILE CATEGORY SET VISIBLE');
		case "fileCatPrivate" : $toDo					= $news->set_annoncecat_state($nId, 0);
								$rub_display_cfrm_msg	= $mod_lang_output['FILE_CAT_HIDDEN_SUCCESS'];  $system->set_log('FILE CATEGORY SET INVISIBLE');
		break;
	}
?>