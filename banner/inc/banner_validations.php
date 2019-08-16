<?php
	/*************INSERT A NEW BANNER*************/
	$sel_banPage		= 	$_POST[sel_banPage];
	$sel_banPosition	= 	$_POST[sel_banPosition];
	$ta_banDescr		= 	addslashes($_POST[ta_banDescr]);
	$fileBan_name		= 	$_FILES[fileBan][name];
	$fileBan_temp		= 	$_FILES[fileBan][tmp_name];
	$ban_dateExpire		= 	$_POST[cmbYear].'-'.$_POST[cmbMonth].'-'.$_POST[cmbDay];
	$txt_banLink		= 	$_POST[txt_banLink];
	$btnBanOk			= 	$_POST[btnBanOk];

	if(isset($btnBanOk)){
		$myBannerImg->set_fileTempName($fileBan_temp);
		$banExt		= $myBanner->get_file_ext($fileBan_name);
		
		//Renommage des bannieres
		$currentId 		= ($myBanner->get_tbl_last_id($myBanner->tbl_banner, $myBanner->fld_bannerId) + 1);
		$ban_fileName 	= $currentId.".".$banExt;
		
		if($myBanner->chk_entry_twice($myBanner->tbl_banner, $myBanner->fld_bannerPageId, $myBanner->fld_bannerPositionId, $sel_banPage, $sel_banPosition)){
			$ban_insert_err_msg	= $mod_lang_output['BANNER_ERROR_SAME_POSITION'];
		}
		elseif($myBanner->set_banner($sel_banPage, $banExt, $sel_banPosition, $ban_fileName, $ta_banDescr, $txt_banLink, $ban_dateExpire)){
			$myBannerImg->set_fileDirectory("../modules/banner/bans/");
			$myBannerImg->fileSend($ban_fileName);
			$ban_insert_cfrm_msg	= $mod_lang_output['BANNER_SUCCESS'];
		}
		else
			$ban_insert_err_msg	= $mod_lang_output['BANNER_ERROR'];
	}
?>

<?php
	/*************UPDATE A BANNER*************/
	$sel_banPageUpd		= $_POST[sel_banPageUpd];
	$sel_banPositionUpd	= $_POST[sel_banPositionUpd];
	$ta_banDescrUpd		= addslashes($_POST[ta_banDescrUpd]);
	$fileBanUpd 		= $_POST[fileBanUpd];
	$fileBanUpd_name	= $_FILES[fileBanUpd][name];
	$fileBanUpd_temp	= $_FILES[fileBanUpd][tmp_name];
	$ban_dateExpireUpd	= $_POST[cmbYearUpd].'-'.$_POST[cmbMonthUpd].'-'.$_POST[cmbDayUpd];
	$txt_banLinkUpd		= $_POST[txt_banLinkUpd];
	$btnBanOkUpd		= $_POST[btnBanOkUpd];
	$hd_fileBan			= $_POST[hd_fileBan];
	$chk_banDisplayUpd	= $_POST[chk_banDisplayUpd];
	$hd_banId			= $_POST[hd_banId];

	if(isset($btnBanOkUpd)){
		if(isset($fileBanUpd_name) && ($fileBanUpd_name != "")){
			$myBannerImg->set_fileTempName($fileBanUpd_temp);
			$banExt		= $myBanner->get_file_ext($fileBanUpd_name);
			
			//Renommage des bannieres
			$currentId 			= $hd_banId;
			$fileBanUpd_name 	= $currentId.".".$banExt;
			
			//Envoi des fichiers sur le serveur
			$myBannerImg->set_fileDirectory("../modules/banner/bans/");
			$myBannerImg->fileSend($fileBanUpd_name);
		}
		else{
			$fileBanUpd_name 	= $hd_fileBan;
			$banExt				= $myBanner->get_file_ext($fileBanUpd_name);
		}
		if($myBanner->update_banner($hd_banId, $fileBanUpd_name, $banExt, $sel_banPageUpd, $sel_banPositionUpd, $ta_banDescrUpd, $txt_banLinkUpd, $ban_dateExpireUpd, $chk_banDisplayUpd)){
			$ban_update_cfrm_msg	= $mod_lang_output['BANNER_UPDATE_SUCCESS'];
		}
		else
			$ban_insert_err_msg	= $mod_lang_output['BANNER_ERROR'];
	}
?>

<?php
	//Actions sur les news et leurs news_catriques
	$what 	= $_REQUEST[what];
	$action	= $_REQUEST[action];
	
	switch($action){
		case "delete" 		: 	$toDo 						= $myBanner->banner_delete($_REQUEST[$myBanner->URI_bannerVar], "../".$myBanner->ban_imgDir);
								$banner_display_cfrm_msg	= $mod_lang_output['BANNER_DELETE_SUCCESS'];
								//Cr&eacute;er le Data Set Correspondant
		break;
		case "hide": 	$toDo						= $myBanner->switch_banner_state($_REQUEST[$myBanner->URI_bannerVar], "0");
								$banner_display_cfrm_msg	= $mod_lang_output['BANNER_HIDDEN_SUCCESS'];
		break;
		case "show":	$toDo						= $myBanner->switch_banner_state($_REQUEST[$myBanner->URI_bannerVar], "1");
								$banner_display_cfrm_msg	= $mod_lang_output['BANNER_VISIBLE_SUCCESS'];
		break;
		
	}
?>