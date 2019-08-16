<?php
	//Category validation
	$btn_cat_insert 		= 	$_POST[btn_cat_insert];
	$txt_gallery_cat 		= 	addslashes($_POST[txt_gallery_cat]);
	$ta_gallery_cat_descr	= 	addslashes($_POST[ta_gallery_cat_descr]);
	$cmbYear				= 	$_POST[cmbYear];
	$cmbMonth				= 	$_POST[cmbMonth];
	$cmbDay					= 	$_POST[cmbDay];
	$selLang				=	$_POST['selLang'];
	$galleryCat_date		= 	"$cmbYear-$cmbMonth-$cmbDay";
	
	if(isset($btn_cat_insert)){
		if(empty($txt_gallery_cat))
			$gallery_cat_insert_err_msg = $mod_lang_output['MSG_CATEGORY_TITLE_ERROR'];
		elseif($gallery->chk_entry($gallery->tbl_galleryCat, "gallery_cat_lib", $txt_gallery_cat))
			$gallery_cat_insert_err_msg = $mod_lang_output['MSG_CATEGORY_EXISTS'];
		elseif(!checkdate($cmbMonth, $cmbDay, $cmbYear))
			$gallery_cat_insert_err_msg = $_mod_lang_ouput['MSG_CATEGORY_DATE_ERROR'];
		elseif($gallery->set_gallery_cat($txt_gallery_cat, $ta_gallery_cat_descr, $galleryCat_date, $selLang))
			$gallery_cat_insert_cfrm_msg = $mod_lang_output['MSG_CATEGORY_CREATE_SUCCESS'];
	}
	
?>
<?php
	//Pix insert validation
	$gallery_selCat 	= $_POST[gallery_selCat];
	$gallery_selLang    = $_POST[gallery_hdLang];
	$gallery_file_name	= $_FILES[gallery_file][name];
	$gallery_file_temp	= $_FILES[gallery_file][tmp_name];
	$gallery_file_size	= $_FILES[gallery_file][size];
	$ta_img_descr		= addslashes($_POST[ta_img_descr]);
	$txt_thumbs_descr	= addslashes($_POST[txt_thumbs_descr]);
	$btn_img_insert		= $_POST[btn_img_insert];
	$cmbDay				= $_POST[cmbDay];
	$cmbMonth			= $_POST[cmbMonth];
	$cmbYear			= $_POST[cmbYear];
	$gallery_date		= "$cmbYear-$cmbMonth-$cmbDay";
	
	if(isset($btn_img_insert)){
		
		$currentId = ($gallery->get_tbl_last_id($gallery->tbl_gallery, $gallery->fld_galleryId) + 1);
		
		//Definir la taille max du fichier
		$gallery->set_fileMaxSize(15360000);
		
		//Renommage du fichier :
		$pixExt = $gallery->get_file_ext($gallery_file_name);
		$gallery_file_name = $currentId.".".$pixExt;
		$pixType	= $gallery->fileImgType;
		
		//Creation du fichier temporaire
		$gallery->set_fileTempName($gallery_file_temp);
		//Definition du repertoire d'envoi des images et des imagettes
		$gallery->set_fileDirectory($gallery->imgs_dir);
		
		//Definition du repertoire spry pour la gallerie
		$gallery->set_spry_data_dir('../modules/gallery/spry/data/');
		
		if($gallery_selLang == 'NULL' OR $gallery_selLang == '')
		    $gallery_insert_err_msg = $mod_lang_output['FORM_ERROR_LANG'];
		elseif(empty($gallery_file_name))
			$gallery_insert_err_msg = $mod_lang_output['MSG_ERROR_NO_IMAGE'];		
		elseif(empty($gallery_selCat) || ($gallery_selCat == 'NULL'))
		    $gallery_insert_err_msg = $mod_lang_output['FORM_ERROR_NO_CAT'];
		elseif($gallery->chk_entry($gallery->tbl_gallery, "gallery_lib", $ta_img_descr))
			$gallery_insert_err_msg = $mod_lang_output['MSG_ERROR_IMAGE_EXISTS'];
		elseif($gallery_file_size > $gallery->fileMaxSize)
			$gallery_insert_err_msg = $mod_lang_output['MSG_ERROR_FILE_SIZE_BIG'].$gallery->fileMaxSize/1024 ." Ko";
		elseif(!in_array($pixExt, $pixType))
			$gallery_insert_err_msg = $mod_lang_output['MSG_ERROR_FILE_TYPE'];
		elseif(!checkdate($cmbMonth, $cmbDay, $cmbYear))
			$gallery_cat_insert_err_msg = $lang_output['MSG_ERROR_DATE'];
		elseif(($gallery->fileSend($gallery_file_name)) && ($gallery->set_gallery($currentId, $gallery_selCat, $gallery_file_name, $ta_img_descr, $txt_thumbs_descr, $gallery_date, $gallery_selLang, '1'))){
			$gallery->create_thumbs($gallery_file_name, "150");
			
			$gallery->set_thumbs_dir($gallery->imgs_dir);
			$gallery->create_thumbs($gallery_file_name, "850");
			$gallery_insert_cfrm_msg = $mod_lang_output['MSG_GALLERY_SUCCESS'];
			$gallery->create_xml_gallery("../modules/gallery/gallery.xml");
			
			//Spry data set
			$gallery->create_spry_ds(); 
			//For step carousel
			$gallery->build_step_carousel("../modules/gallery/homecarousel.gzk", $pageGallery, 20);
		}
	}
?>

<?php
	//Pix update validation
	$gallery_file_name_upd	= $_FILES[gallery_file_upd][name];
	$selCat_upd 			= $_POST[selCat_upd];
	$ta_img_descr_upd		= addslashes($_POST[ta_img_descr_upd]);
	$txt_thumbs_descr_upd	= addslashes($_POST[txt_thumbs_descr_upd]);
	$btn_img_update			= $_POST[btn_img_update];
	$hd_galleryId			= $_POST[hd_galleryId]; //ID de l'enreg a maj
	$hd_publishId			= $_POST[hd_publishId];
	$cmbYearUpd				= $_POST[cmbYearUpd];
	$cmbMonthUpd			= $_POST[cmbMonthUpd];
	$cmbDayUpd				= $_POST[cmbDayUpd];
	$gallery_dateUpd		= "$cmbYearUpd-$cmbMonthUpd-$cmbDayUpd";
	
	if(isset($btn_img_update)){
		//Obtenir le nom du fichier a mettre a jour
		$old_pixName	= $gallery->get_gallery_lib_by_id($hd_galleryId);
		
		if(empty($gallery_file_name_upd)){//Si pas fichier, mettre a jour...
			if($gallery->update_gallery($hd_galleryId, $selCat_upd, $old_pixName, $ta_img_descr_upd, $txt_thumbs_descr_upd, $gallery_dateUpd, $hd_publishId))
				$gallery_update_cfrm_msg .= $mod_lang_output['MSG_GALLERY_UPDATE_SUCCESS'];
		}
		//Si on a selectionne une image de remplacement :
		else{
			
			/******** TRAVAUX SUR LE FICHIER SELECTIONNE*/
			$gallery_file_temp_upd	= $_FILES[gallery_file_upd][tmp_name];
			$gallery_file_size_upd	= $_FILES[gallery_file_upd][size];
			//Definir la taille max du fichier
			$gallery->set_fileMaxSize(15360000);
			
			//On recupere l'extension du nouveau fichier :
			$old_pixExt		= $gallery->get_file_ext($old_pixName);
			$pixExt 		= $gallery->get_file_ext($gallery_file_name_upd);
			
			//Recuperation des noms des fichiers  sans leurs extensions:
			//Ancien :
			$old_pixName	 		= basename($old_pixName, $old_pixExt);
			//Nouveau :
			$gallery_file_name_upd 	= basename($gallery_file_name_upd, $pixExt);
			
			//On prend l'ancien nom, on concatene a l'extension du nouveau fichier...
			$gallery_file_name_upd 	= $old_pixName.$pixExt;
			$pixType				= $gallery->fileImgType;
			
			//Creation du fichier temporaire
			$gallery->set_fileTempName($gallery_file_temp_upd);
			//Definition du repertoire d'envoi des images et des imagettes
			$gallery->set_fileDirectory($gallery->imgs_dir);
			/******** FIN TRAVAUX SUR LE FICHIER SELECTIONNE*/
			
			if(!in_array($pixExt, $pixType))
				$gallery_update_err_msg = $mod_lang_output['MSG_ERROR_FILE_TYPE'];
			elseif($gallery_file_size_upd > $gallery->fileMaxSize)
				$gallery_update_err_msg = $mod_lang_output['MSG_ERROR_FILE_SIZE_BIG'].$gallery->fileMaxSize/1024 ." Ko";
			elseif (!checkdate($cmbMonthUpd, $cmbDayUpd, $cmbYearUpd))
				$gallery_update_err_msg = $lang_output['MSG_ERROR_DATE'];
			elseif($gallery->fileSend($gallery_file_name_upd) && ($gallery->update_gallery($hd_galleryId, $selCat_upd, $gallery_file_name_upd, $ta_img_descr_upd, $txt_thumbs_descr_upd, $gallery_dateUpd, $hd_publishId))){
				//$gallery->set_fileDirectory($gallery->thumbs_dir);
				$gallery->create_thumbs($gallery_file_name_upd, "150");
				
				//redefinition du repertoire des images et de la taille de ces images, prenant 850 px kom largeur des images 
				$gallery->set_fileDirectory($gallery->imgs_dir);
				$gallery->set_thumbs_dir($gallery->imgs_dir);
				$gallery->create_thumbs($gallery_file_name_upd, "850");
				$gallery_update_cfrm_msg .= $mod_lang_output['MSG_GALLERY_UPDATE_SUCCESS'];
				$gallery->create_xml_gallery("../modules/gallery/gallery.xml");
				//Step carousel updating
				$gallery->build_step_carousel("../modules/gallery/homecarousel.gzk", $pageGallery, 20);
			}
		}
		
		//Traceur....
		/*if(isset($gallery_file_name_upd)){
			print $gallery_file_name_upd;
		}*/
	}
?>

<?php
	//Suppressions et modifications
	switch($_REQUEST[action]){
		case "galleryCatDelete" : $gallery->delete_gallery_cat($_REQUEST[$gallery->URI_galleryCatVar]);
		break;
		case "galleryCatUpdate" : $tab_galleryCat = $gallery->get_gallery_cat($_REQUEST[$gallery->URI_galleryCatVar]); $catUpdate = "true";
		break;
		case "galleryDelete" : 	$imgURL 	= $gallery->img_dir.$gallery->get_gallery_by_id("gallery_lib", $_REQUEST[$gallery->URI_galleryVar]);
								$thumbURL 	= $gallery->thumbs_dir.$gallery->get_gallery_by_id("gallery_lib", $_REQUEST[$gallery->URI_galleryVar]);
								if($gallery->delete_thumb($_REQUEST[$gallery->URI_galleryVar], $thumbURL, $imgURL)){
									$gallery_display_cfrm_msg = $mod_lang_output['MSG_GALLERY_DELETE_SUCCESS'];
									$gallery->create_xml_gallery("../modules/gallery/gallery.xml");
								}
		break;
		case "galleryPublish"    : $gallery->switch_gallery_state($_REQUEST[$gallery->URI_galleryVar], "1"); $gallery_display_cfrm_msg = $mod_lang_output['MSG_GALLERY_SHOW_SUCCESS'];
		break;
		case "galleryPrivate" 	: $gallery->switch_gallery_state($_REQUEST[$gallery->URI_galleryVar], "0");  $gallery_display_cfrm_msg = $mod_lang_output['MSG_GALLERY_HIDE_SUCCESS'];
		break;
		case "gallery_commentPrivate": $toDo				= $gallery->switch_gallery_comment_state($gallery->URI_galleryCatVar, "0");
							$cfrm_galleryCommentDisplay	= "Commentaire masqu&eacute; avec succ&egrave;s.";
		break;
		case "gallery_commentPublish":	$toDo				= $gallery->switch_gallery_comment_state($gallery->URI_galleryCatVar, "1");
							$cfrm_galleryCommentDisplay	= "Vous avez publi&eacute; un commentaire avec succ&egrave;s.";
		break;
		case "gallery_commentDelete" : $toDo				= $gallery->del_gallery_comment($gallery->URI_galleryCatVar);
							$cfrm_galleryCommentDisplay	= "Commentaire supprim&eacute; avec succ&egrave;s";
		break;
	}
	
	//Suppression massive
	if(isset($_POST[btn_deleteSelectedGallery])){
		//Traceur 1 -->  print "Tableau des images choisies : ".$gallery->extractArray($_POST[$gallery->URI_galleryVar]);
		$n = 0;
		foreach($_POST[$gallery->URI_galleryVar] as $value){
			$delete_fileName		= $gallery->get_gallery_by_id("gallery_lib", $value);
			//Chemin complet vers le fichier principal
			$delete_fileSrc			= $gallery->imgs_dir.$delete_fileName;
			//Chemin complet vers la miniature
			$delete_thumbSrc		= $gallery->thumbs_dir.$delete_fileName;
			//Traceur 2 -->  print "Main : $delete_fileSrc -- Thumb : $delete_thumbSrc <br />";
			$result = $gallery->delete_thumb($value, $delete_thumbSrc, $delete_fileSrc);
			$n++;
		}
		$system->set_log($n.' IMAGES DELETED IN GALLERY');
		if($result){
			$msg_single 	= $lang_output['MSG_CONGRATULATIONS']."!<br />$n ".$mod_lang_output['MSG_IMAGE_DELETED'];
			$msg_multiple	= $lang_output['MSG_CONGRATULATIONS']."!<br />$n ".$mod_lang_output['MSG_IMAGES_DELETED'];
			
			$gallery_display_cfrm_msg = (($n==1) ? $msg_single : $msg_multiple);
			$gallery->create_xml_gallery("../modules/gallery/gallery.xml");
		}
	}
	
	//Modification des albums
	$btn_cat_upd				= $_POST[btn_cat_upd];
	$hd_gallery_cat_id			= $_POST[hd_gallery_cat_id];
	$txt_gallery_cat_upd		= addslashes($_POST[txt_gallery_cat_upd]);
	$ta_gallery_cat_descr_upd	= addslashes($_POST[ta_gallery_cat_descr_upd]);
	$cmbYearUpd					= $_POST[cmbYearUpd];
	$cmbMonthUpd				= $_POST[cmbMonthUpd];
	$cmbDayUpd					= $_POST[cmbDayUpd];
	$galleryCat_date_upd		= "$cmbYearUpd-$cmbMonthUpd-$cmbDayUpd";
	
	
	if(isset($_POST[btn_cat_upd])){
		if(empty($_POST[txt_gallery_cat_upd]))
			$gallery_cat_update_err_msg = $mod_lang_output['MSG_CATEGORY_TITLE_ERROR'];
		if(!checkdate($cmbMonthUpd, $cmbDayUpd, $cmbYearUpd))
			$gallery_cat_update_err_msg = $mod_lang_output['MSG_CATEGORY_DATE_ERROR'];
		elseif($gallery->update_gallery_cat($hd_gallery_cat_id, $txt_gallery_cat_upd, $ta_gallery_cat_descr_upd, $galleryCat_date_upd)){
			$gallery_cat_update_cfrm_msg = $mod_lang_output['MSG_CATEGORY_UPDATE_SUCCESS'];
			$gallery->create_xml_gallery("../modules/gallery/gallery.xml");
		}
	}
	
?>