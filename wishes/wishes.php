<?php
	//:::::::::::::::::::::::::::::::wishes Module:::::::::::::::::::::::::::::::
	require_once('library/wishes.inc.php');
	$myWishes 		= new cwd_wishes();
	$pageWishes		= $myPage->get_pages_modules_links("wishes", $_SESSION["LANG"]);	 
	$wishesTxt		= $myWishes->display_valid_wishes($pageWishes);
	$wishesAll		= $myWishes->get_valid_wishes("DESC");
	
	if($_REQUEST[level] == 'front'){
		$wishesHome	= 	"<div id=\"TICKER\" style=\"overflow:hidden; width:550px; margin-right:5px;\"  onmouseover=\"TICKER_PAUSED=true\" onmouseout=\"TICKER_PAUSED=false\">
								$wishesTxt
							</div>
							<div style=\"margin:0; padding:0;\">
								<p style=\"text-align:right; font-weight:bold;\"><a href=\"$pageWishes$thewu32_appExt\">Vous aussi, envoyez vos voeux maintenant&nbsp;!&nbsp;&raquo;</a></p>
							</div>
		                    <script type=\"text/javascript\" src=\"scripts/jsfiles/webticker_lib.js\" language=\"javascript\"></script>";
							
		//actions for homepage render
	}
	elseif($_REQUEST[mod] == 'wishes'){
		if($_REQUEST[level] =='inner'){		
			//Initialisation du formulaire de reaction
			//Obtenir les informations de l'utilisateur connecté...
			$txt_wishesEmail 	= $_POST[txt_wishesEmail];
			$txt_wishesName  	= addslashes($_POST[txt_wishesName]);
			
			//$txtContent 		= $my_article->protect_box(addslashes($_POST["txtContent"]));
			$ta_wishesContent 	= addslashes($_POST[ta_wishesContent]);
			$btn_wishesInsert 	= $_POST[btn_wishesInsert];
			$security_code 		= $_POST[security_code];
			
			//Validation du formulaire de reaction
			if(isset($btn_wishesInsert)){
				if(empty($ta_wishesContent)){
					$err_wishesInsert 	= "Erreur!<br />Vous devez ins&eacute;rer un contenu avant de continuer svp!";
				}
				elseif($myWishes->chk_entry($myWishes->tbl_wishes, "wishes_content", $ta_wishesContent))
					$err_wishesInsert = "Erreur!<br />Ce v&oelig;u a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute;e...";
				elseif(!$myWishes->chk_mail($txt_wishesEmail))
					$err_wishesInsert = "Erreur!<br />Veuillez saisir un e-mail valide";
				elseif(($_POST['security_code'] != $_SESSION['security_code']) || (empty($_SESSION['security_code'])) ){
					unset($_SESSION['security_code']);
					$err_wishesInsert = "Erreur!<br />Code de s&eacute;curit&eacute; obligatoire pour continuer...<br />Veuillez saisir le code de s&eacute;curit&eacute; svp!";
				}
				elseif($myWishes->insert_wishes($txt_wishesName, $txt_wishesEmail, $ta_wishesContent)){
					unset($_SESSION['security_code']);
					$cfrm_wishesInsert	= "Bravo!<br />Votre v&oelig;u a &eacute;t&eacute; pris en compte et sera affich&eacute; &agrave; la page d'accueil<br /> du site ya-fe.com!";			
				}
				else
					$err_wishesInsert = "Impossible d'ajouter votre v&oelig;u!!<br />Nous nous excusons pour la g&egrave; ne occasionn&eacute;e. Veuillez reessayer ulterieurement";
			}
			
			if(isset($err_wishesInsert)){
		$frm_msgDisplay	= "<div class=\"boxErr\">$err_wishesInsert;</div>";
	}
	if(isset($cfrm_wishesInsert)){
		$frm_msgDisplay	= "<div class=\"boxCfrm\">$cfrm_wishesInsert;</div>";
	}
	
	$frm_insertWishes	= "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"\">
             		$frm_msgDisplay
		  			<table width=\"100%\" border=\"0\" class=\"yafe_tbl\">
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <th width=\"27%\" align=\"right\">Nom : </th>
                          <td width=\"3%\">&nbsp;</td>
                          <td width=\"70%\">
                            <input name=\"txt_wishesName\" type=\"text\" id=\"txt_wishesName\" size=\"40\" value=\"".$myWishes->show_content($err_wishesInsert, $txt_wishesName)."\" />
                          </td>
                        </tr>
                        <tr>
                          <th align=\"right\">Email : </td>
                          <td>&nbsp;</td>
                          <td>
                            <input name=\"txt_wishesEmail\" type=\"text\" id=\"txt_wishesEmail\" size=\"40\" value=\"".$myWishes->show_content($err_wishesInsert, $txt_wishesEmail)."\" />
                          </td>
                        </tr>
                        <tr>
                          <th colspan=\"3\" align=\"center\">Votre message : <span style=\"font-style:italic; font-weight:normal;\">(100 caract&egrave;res maximum)</span></th>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"center\">
                            <textarea onkeyup=\"Compter(this, this.form.CharRestant);\" name=\"ta_wishesContent\" id=\"ta_wishesContent\" cols=\"50\" rows=\"7\">".$myWishes->show_content($err_wishesInsert, $ta_wishesContent)."</textarea>
                          </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><img src=\"captcha.php\" /><br />
				  	<input style=\"font-family:'Comic Sans MS', 'Times New Roman', Times, serif; width:144px; height:40px; font-size:300%; font-weight:bold;\" size=\"5\" name=\"security_code\" type=\"text\" value=\"Code ici\" onclick=\"this.value=''\" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><label>
                            <input type=\"submit\" name=\"btn_wishesInsert\" id=\"btn_wishesInsert\" value=\"Envoyer\" />
                          </label></td>
                        </tr>
                  </table>
                </form>";
      			$pageContent	= stripslashes(utf8_encode($frm_insertWishes."<br />".$wishesAll));
		}
	}
?>

<?php
	//Home display 
	$oSmarty->assign('s_wishesHome', stripslashes($wishesHome));
	
	//
	$oSmarty->assign('s_wishesAll', stripslashes($wishesAll));	
	
	//Form vars
	$oSmarty->assign('s_wishes_txtName', stripslashes($wishes_txtName));
	$oSmarty->assign('s_wishes_txtEmail', stripslashes($wishes_txtEmail));
	$oSmarty->assign('s_wishes_taContent', stripslashes($wishes_taContent));
?>
