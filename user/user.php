<?php
	require_once ('library/user.inc.php');
	$myUser						=	new cwd_user();
	$userPage					= 	$myPage->get_pages_modules_links("user", $pageLang);
	
	$pageUser		       		=   $myPage->get_pages_modules_links("user", $_SESSION["LANG"]); //$thewu32_modLink[annonce];
	$pageMaster         		=   $myPage->set_mod_page_master($pageUser); //Vers la page du module gallery dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster			=   $myPage->get_mod_link($myPage->set_mod_pages($pageUser), $mod_lang_output['USER_BOX_LINK_ALL']); // Lien vers la page master
	
	if($_REQUEST['level'] 		== 'front'){
	    //Nothing to do
	}
	elseif($_REQUEST['mod']    	==  'user'){
	    $pageHeader     		=   $mod_lang_output['USER_PAGE_HEADER'];
	    if($_REQUEST['level']  	==  'inner'){
			//Nothing to do
	    }
	}
	
	//User Login Form
	$userLogin	=	"<div class=\"user_connect\">
						<div class=\"user_connect_title\"><i class=\"fa fa-lock\"></i>".$mod_lang_output['FORM_HEADER_CONNECT']."</div>
						<div class=\"user_connect_content\">
							$connectionMsg
							<form method=\"POST\" action=\"\">
								<div class=\"frmLine\"><i class=\"fa fa-user\"></i><input placeholder=\"".$mod_lang_output['FORM_LABEL_USER-NAME']."\" name=\"txtLogin\" type=\"text\" id=\"txtLogin\" value=\"\" required /></div>
								<div class=\"frmLine\"><i class=\"fa fa-key\"></i><input placeholder=\"".$mod_lang_output['FORM_LABEL_PASSWORD']."\" name=\"txtPass\" type=\"password\" id=\"txtPass\" value=\"\" required /></div>
								<div class=\"frmLine\"><input type=\"submit\" name=\"btnConnect\" value=\"".strtoupper($mod_lang_output['FORM_BUTTON_CONNECT'])."\" /><input name=\"hd_connectionPage\" type=\"hidden\" value=\"$memberPage\" /></div>
							</form>
						</div>
					</div>
					";
	//Assignations
	$oSmarty->assign('s_userLoginForm', $userLogin);